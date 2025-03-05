<?php

class Review
{
    public ?int $id;
    public ?int $user_id;
    public ?int $movie_id;
    public ?int $rating;
    public ?string $description;
    public ?string $created_at;
    public ?string $updated_at;

    public function toJson(): string
    {
        return json_encode([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'movie_id' => $this->movie_id,
            'rating' => $this->rating,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
