<?php

use App\Models\Chirp;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('searching chirps filters the results', function () {
    $matchingChirp = Chirp::factory()->create(['message' => 'This is a unique test chirp string']);
    $nonMatchingChirp = Chirp::factory()->create(['message' => 'Something else entirely']);

    $response = $this->get('/?search=unique test chirp');

    $response->assertStatus(200);
    $response->assertSee('This is a unique test chirp string');
    $response->assertDontSee('Something else entirely');
});
