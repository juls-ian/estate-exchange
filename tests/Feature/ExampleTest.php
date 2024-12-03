<?php
use function Pest\Laravel\{get, post, put, delete};
it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});