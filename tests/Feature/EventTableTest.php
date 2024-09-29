<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTableTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_event_create(): void
    {
        $event = Event::factory()->create();
        $event_first_day = EventType::where('name', '初日')->firstOrFail();
        $event_last_day = EventType::where('name', '最終日')->firstOrFail();

        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_first_day->id,
            'date' => $event->start_at,
            'editable' => false,
        ]);
        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_last_day->id,
            'date' => $event->end_at,
            'editable' => false,
        ]);
    }

    public function test_event_start_update(): void
    {
        $event = Event::factory()->create();
        $event_first_day = EventType::where('name', '初日')->firstOrFail();
        $event_last_day = EventType::where('name', '最終日')->firstOrFail();

        $event->start_at = today();
        $event->save();

        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_first_day->id,
            'date' => $event->start_at,
            'editable' => false,
        ]);
        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_last_day->id,
            'date' => $event->end_at,
            'editable' => false,
        ]);
    }

    public function test_event_end_update(): void
    {
        $event = Event::factory()->create();
        $event_first_day = EventType::where('name', '初日')->firstOrFail();
        $event_last_day = EventType::where('name', '最終日')->firstOrFail();

        $event->end_at = today();
        $event->save();

        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_first_day->id,
            'date' => $event->start_at,
            'editable' => false,
        ]);
        $this->assertDatabaseHas('event_dates', [
            'event_id' => $event->id,
            'event_type_id' => $event_last_day->id,
            'date' => $event->end_at,
            'editable' => false,
        ]);
    }

    public function test_event_delete(): void
    {
        $event = Event::factory()->create();
        $id = $event->id;
        $event->delete();
        $count = EventDate::where('event_id', $id)->count();
        $this->assertSame($count, 0);
    }
}
