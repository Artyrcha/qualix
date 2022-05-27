<?php
const PAGE_SIZE = 10;

if (file_exists('posts.json')) {
    $query = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'));
} else {
    $query = file_get_contents('https://jsonplaceholder.typicode.com/posts');
    $fp = fopen('posts.json', 'w');
    fwrite($fp, $query);
    fclose($fp);
    $query = json_decode($query);
}

$currentPage = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$countPages = ceil(sizeof($query) / PAGE_SIZE);
$posts = array_slice($query, ($currentPage - 1) * PAGE_SIZE, 10);
?>

    <ul style="list-style: none">
        <?php foreach ($posts as $post): ?>
            <li>
                <span><?= $post->id; ?></span> <a href="/posts/<?= $post->id ?>/"><?= $post->title ?></a>
                <div class=""><?= $post->body ?></div>
            </li>
        <?php endforeach; ?>
    </ul>

<?php if ($currentPage > 1): ?>
    <a href="?page=<?= $currentPage - 1 ?>">Предыдущая страница</a>
<?php endif; ?>
<?php if ($currentPage < $countPages): ?>
    <a href="?page=<?= $currentPage + 1 ?>">Следующая страница</a>
<?php endif; ?>