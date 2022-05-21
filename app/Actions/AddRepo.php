<?php

namespace App\Actions;

use App\Models\Repo;
use App\Repositories\RepoRepository;

class AddRepo
{
    public function __construct(
        protected string $owner,
        protected string $name
    ) {
    }

    public function execute(): void
    {
        if (Repo::whereOwner($this->owner)->whereName($this->name)->doesntExist()) {
            $data = (new FetchRepo($this->owner, $this->name))->execute();
            app(RepoRepository::class)->create($data);
        }
    }
}
