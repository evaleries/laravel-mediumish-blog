# Simple Blog with JSON as a database

This repository contains my mid-semester work.
I'm using Collection and Storage Facades.

## Implementation

I've implemented a simple ORM-based from JSON file. Check out the `app/Article.php`

### Find an Article By Id

```php
$article = Article::findById($id);
$article->title;
$article->content;
```
 
### Create a new Article

```php
Article::create([
    'id' => 1, 
    'title' => 'Test', 
    'content' => 'Testing content'
]);
```

### Update an article

```php
Article::findById($id)->update($request->all());
```

### Delete an article

```php
Article::findById($id)->delete();
```


#### Credits

Thanks to Wowthemes for the mediumish theme.
