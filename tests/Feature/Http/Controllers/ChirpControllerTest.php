<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\NewChirp;
use App\Models\Chirp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChirpController
 */
final class ChirpControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $chirps = Chirp::factory()->count(3)->create();

        $response = $this->get(route('chirp.index'));

        $response->assertOk();
        $response->assertViewIs('chirps.index');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('chirp.create'));

        $response->assertOk();
        $response->assertViewIs('chirps.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChirpController::class,
            'store',
            \App\Http\Requests\ChirpStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $message = $this->faker->word();

        Event::fake();

        $response = $this->post(route('chirp.store'), [
            'message' => $message,
        ]);

        $chirps = Chirp::query()
            ->where('message', $message)
            ->get();
        $this->assertCount(1, $chirps);
        $chirp = $chirps->first();

        $response->assertRedirect(route('chirps.index'));
        $response->assertSessionHas('chirp.message', $chirp->message);

        Event::assertDispatched(NewChirp::class);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $chirp = Chirp::factory()->create();

        $response = $this->get(route('chirp.show', $chirp));

        $response->assertOk();
        $response->assertViewIs('chirps.show');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $chirp = Chirp::factory()->create();

        $response = $this->get(route('chirp.edit', $chirp));

        $response->assertOk();
        $response->assertViewIs('chirps.edit');
    }


    #[Test]
    public function update_redirects(): void
    {
        $chirp = Chirp::factory()->create();

        $response = $this->put(route('chirp.update', $chirp));

        $chirp->refresh();

        $response->assertRedirect(route('chirps.index'));
        $response->assertSessionHas('chirp.message', $chirp->message);
    }


    #[Test]
    public function destroy_deletes(): void
    {
        $chirp = Chirp::factory()->create();

        $response = $this->delete(route('chirp.destroy', $chirp));

        $response->assertSessionHas('chirp.message', $chirp->message);

        $this->assertModelMissing($chirp);
    }
}
