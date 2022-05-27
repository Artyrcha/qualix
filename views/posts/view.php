<?php
if (!$_GET['id']) exit;
//$post = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/posts/$id"));

if (file_exists('posts.json')) {
    $posts = json_decode(file_get_contents('posts.json'));
} else {
    $posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'));
}

$post = array_filter($posts, function ($item) {
    return $item->id == $_GET['id'];
})[0];

?>

<h1><?= $post->title; ?></h1>
<p><?= $post->body; ?></p>

<button>Загрузить комментарии</button>
<ul id="comments" style="display: none"></ul>

<script>
    const id = <?= $_GET['id']; ?>;

    document.addEventListener("DOMContentLoaded", () => {
        const button = document.querySelector('button');
        button.addEventListener('click', (e) => {
            e.preventDefault();

            button.style.display = "none";

            fetch(`https://jsonplaceholder.typicode.com/posts/${id}/comments`)
                .then((response) => {
                    return response.json();
                })
                .then((comments) => {
                    const listNode = document.querySelector('#comments');

                    for (comment of comments) {
                        listNode.insertAdjacentHTML('beforeend',
                            `<li>
                                <div><strong>Name:</strong> ${comment.name}</div>
                                <div><strong>Email:</strong> <i>${comment.email}</i></div>
                                <p>${comment.body}</p>
                            </li>`);
                    }

                    listNode.style.display = "block";
                });
        })
    });
</script>