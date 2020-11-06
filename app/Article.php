<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Simple ORM file-based
 * 
 * @author evaleries <182410102083@cs.unej.ac.id>
 */
class Article {

    private $fileName = 'articles.json';

    protected $attributes = [
        'id',
        'title',
        'slug',
        'article_image',
        'content',
        'author',
        'author_image',
        'created_at',
    ];

    /**
     * Current Article
     *
     * @var array
     */
    protected $currentArticle;

    /**
     * Loaded articles
     *
     * @var array|Collection
     */
    private $contents;

    function __construct()
    {
        if (! Storage::exists($this->fileName)) {
            Storage::put($this->fileName, '[]');
        }

        $this->load();
    }

    public static function fromArray($attributes)
    {
        $instance = new static;
        $instance->currentArticle = $attributes;

        return $instance;
    }

    /**
     * Load articles as an array.
     *
     * @return array
     */
    private function load()
    {
        return $this->contents = $this->contents ?: 
            collect(json_decode(Storage::get($this->fileName), true));
    }

    private function reload()
    {
        $this->contents = null;
        $this->contents = $this->load();
        
        return $this;
    }

    protected function all()
    {
        return $this->contents->map(function ($item) {
            return Article::fromArray($item);
        });
    }

    protected function latest()
    {
        return $this->all()->reverse();
    }

    protected function find($id)
    {
        return $this->contents->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });
    }

    protected function create($attributes)
    {
        // abort_unless(array_keys($attributes) == collect($this->attributes)->except(0)->toArray(), 422, 'Terdapat data yang kosong!');

        if (isset($attributes['id']) && ($key = $this->find($attributes['id'])) !== false) {
            return $this->contents->get($key);
        }

        $attributes['id'] = ($this->contents->last()['id'] ?? 0) + 1;
        $attributes['slug'] = Str::slug($attributes['title'] ?? '');
        $attributes['created_at'] = now()->timestamp;

        unset($attributes['_token']);
        unset($attributes['_method']);

        $this->contents->push($attributes);
        $this->save()->reload();

        return $this->contents->last();
    }

    public function update($attributes)
    {
        $articleKey = $this->find(($this->currentArticle['id'] ?? $attributes['id']) ?? -1);
        abort_if($articleKey === false, 404, 'Artikel tidak ditemukan!');

        $article = array_replace(
            $this->contents->get($articleKey),
            $attributes
        );

        $this->contents = $this->contents->replace([$articleKey => $article]);
        $this->save()->reload();

        return $this->contents->get($articleKey, null);
    }

    public function delete($articleId = null)
    {
        $articleKey = $this->find($articleId ?? $this->currentArticle['id']);
        abort_if($articleKey === false, 404, 'Artikel tidak ditemukan');

        $this->contents->forget($articleKey);
        $this->save();
    }

    protected function findById($id)
    {
        $key = $this->find($id);

        if ($key !== false) {
            $this->currentArticle = $this->contents->get($key);
            return $this;
        }

        abort(404, 'Artikel tidak ditemukan');
    }

    protected function first($id)
    {
        return Article::fromArray($this->findById($id)->currentArticle);
    }

    /**
     * Saves the content
     *
     * @return Article
     */
    public function save()
    {
        Storage::put($this->fileName, $this->prepareSave());
        return $this;
    }

    /**
     * Converts the contents to string
     *
     * @return string
     */
    protected function prepareSave()
    {
        if (is_array($this->contents)) {
            return json_encode($this->contents);
        }

        if ($this->contents instanceof Collection) {
            return json_encode($this->contents->toArray());
        }

        return '[]';
    }

    public function __get($attribute)
    {
        if (!empty($this->currentArticle)) {
            return $this->currentArticle[$attribute] ?? null;
        }

        return null;
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = resolve(Article::class);
        
        return call_user_func_array([$instance, $name], $arguments);
    }

    public function __toString()
    {
        return json_encode($this->currentArticle);
    }
}
