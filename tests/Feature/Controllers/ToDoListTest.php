<?php

namespace Tests\Feature\Controllers;

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class ToDoListTest extends TestCase
{
    use RefreshDatabase;

    protected ToDoList $list;

    protected ListItem $item;

    protected array $data;

    protected array $incorrectData;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = ToDoList::factory()->create();

        $this->data = [
            'content' => Str::random(16),
        ];

        $this->incorrectData = [
            'content' => Str::random(5000),
        ];
    }

    /** @test */
    public function it_can_access_to_do_list()
    {
        $this->get(route('toDoList'))
            ->assertSuccessful()
            ->assertComponentIs('ToDoList')
            ->assertPropValue('list', function ($viewData) {
                $this->assertEquals(
                    Arr::get($viewData, 'data.id'),
                    $this->list->guid
                );
            });
    }

    /** @test */
    public function it_will_create_a_new_to_do_list_if_one_is_not_present()
    {
        $this->list->delete();

        $this->get(route('toDoList'))
            ->assertSuccessful()
            ->assertComponentIs('ToDoList')
            ->assertPropValue('list', function ($viewData) {
                $this->assertNotNull(
                    Arr::get($viewData, 'data.id'),
                );
            });
    }

    /** @test */
    public function it_can_add_an_item_to_the_list()
    {
        $this->post(route('toDoList.store', $this->list->guid), $this->data)
            ->assertRedirect(route('toDoList'));

        $list = $this->list->fresh();

        $this->assertDatabaseHas('list_items', [
            'list_id' => $list->id,
            'content' => Arr::get($this->data, 'content')
        ]);

        $this->assertCount(1, $list->listItems);
    }

    /** @test */
    public function incorrect_data_will_throw_an_error_adding_to_list()
    {
        $this->post(route('toDoList.store', $this->list->guid), $this->incorrectData)
            ->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function an_incorrect_guid_will_throw_an_error_adding_to_list()
    {
        $this->post(route('toDoList.store', Str::uuid()->toString()), $this->data)
            ->assertNotFound();
    }

    /** @test */
    public function it_can_mark_an_item_as_complete_on_this_list()
    {
        $this->item = ListItem::factory()->create(['list_id' => $this->list->id]);

        $this->put(route('toDoList.update', $this->item->guid))
            ->assertRedirect(route('toDoList'));

        $list = $this->item->fresh();

        $this->assertEquals(true, $list->completed);
    }

    /** @test */
    public function an_incorrect_guid_will_throw_an_error_completing_list_item()
    {
        $this->put(route('toDoList.update', Str::uuid()->toString()))
            ->assertNotFound();
    }


    /** @test */
    public function it_can_delete_list_item()
    {
        $this->item = ListItem::factory()->create(['list_id' => $this->list->id]);

        $this->delete(route('toDoList.delete', $this->item->guid))
            ->assertRedirect(route('toDoList'));

        $this->assertSoftDeleted('list_items', [
            'id' => $this->item->id,
        ]);
    }

    /** @test */
    public function an_incorrect_guid_will_throw_an_error_deleting_list_item()
    {
        $this->delete(route('toDoList.delete', Str::uuid()->toString()))
            ->assertNotFound();
    }
}
