<?php

class Movie
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $genre = null;
    public ?int $year = null;
    public ?string $poster = null;
    public ?string $description = null;

    public function query(array $where = [], array $params = [], $order = 'title ASC')
    {
        $database = new Database(config('database'));

        return $database
            ->query(
                "SELECT 
                    movies.*
                FROM movies 
                -- LEFT JOIN reviews ON movies.id = reviews.movie_id
                WHERE " . implode(" AND ", $where) . " 
                GROUP BY movies.id 
                ORDER BY $order",
                $params,
                Movie::class
            );
    }

    public static function get(int $id): ?Movie
    {
        return (new self)
            ->query(
                ['movies.id = :id'],
                ['id' => $id],
            )
            ->fetch();
    }

    public function getImage(): string
    {
        // when url just return it
        if (filter_var($this->poster, FILTER_VALIDATE_URL)) {
            return $this->poster;
        }

        // when image exists in storage, make it as base64
        return Storage::base64($this->poster) ?? 'https://placehold.co/500x400';
    }
}
