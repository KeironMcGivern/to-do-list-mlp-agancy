<?php

namespace Tests\Unit\Models;

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_soft_deleted()
    {
        $listItem = ListItem::factory()->withList()->create();

        $listItem->delete();

        $this->assertSoftDeleted('list_items', [
            'id' => $listItem->id,
        ]);
    }

    /** @test */
    public function it_can_force_deleted()
    {
        $listItem = ListItem::factory()->withList()->create();

        $listItem->forceDelete();

        $this->assertDatabaseMissing('list_items', [
            'id' => $listItem->id,
        ]);
    }

    /** @test */
    public function it_can_generate_guid()
    {
        $listItem = ListItem::factory()->withList()->create();

        $this->assertNotNull($listItem->guid);
    }

    /** @test */
    public function it_can_have_list()
    {
        $list = ToDoList::factory()->create();
        $listItem = ListItem::factory()->create(['list_id' => $list->id]);

        $this->assertInstanceOf(ToDoList::class, $listItem->list);
        $this->assertEquals($list->id, $listItem->list->id);
    }

    /** @test */
    public function it_can_be_marked_as_completed()
    {
        $listItem = ListItem::factory()->withList()->create();

        $listItem->markedAsComplete();

        $this->assertDatabaseHas('list_items', [
            'id' => $listItem->id,
            'completed' => true,
        ]);
    }
}
