<?php

namespace Tests\Unit\Models;

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToDoListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_soft_deleted()
    {
        $list = ToDoList::factory()->create();

        $list->delete();

        $this->assertSoftDeleted('to_do_lists', [
            'id' => $list->id,
        ]);
    }

    /** @test */
    public function it_can_force_deleted()
    {
        $list = ToDoList::factory()->create();

        $list->forceDelete();

        $this->assertDatabaseMissing('to_do_lists', [
            'id' => $list->id,
        ]);
    }

    /** @test */
    public function it_can_generate_guid()
    {
        $list = ToDoList::factory()->create();

        $this->assertNotNull($list->guid);
    }

    /** @test */
    public function it_can_have_list_items()
    {
        $list = ToDoList::factory()->create();
        ListItem::factory()->count(10)->create(['list_id' => $list->id]);

        $list = $list->fresh();

        $this->assertInstanceOf(ListItem::class, $list->listItems->first());
        $this->assertCount(10, $list->listItems);
    }
}
