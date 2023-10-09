// menu.js

document.addEventListener("DOMContentLoaded", function () {
    const openMenuButton = document.getElementById("openMenuButton");
    const menuDiv = document.createElement("div");
    menuDiv.className = "menu";
    menuDiv.style.display = "none"; // Initially hide the menu

    const buttonsDiv = document.createElement("div");

    const logoutButton = document.createElement("button");
    logoutButton.textContent = "Logout";
    logoutButton.onclick = function () {
        location.href = 'logout.php';
    };

    const createSubredditButton = document.createElement("button");
    createSubredditButton.textContent = "Create board";
    createSubredditButton.onclick = function () {
        location.href = 'subreddit_create.php';
    };

    const createPostButton = document.createElement("button");
    createPostButton.textContent = "Create Post";
    createPostButton.onclick = function () {
        location.href = 'create_post.php';
    };

    buttonsDiv.appendChild(logoutButton);
    buttonsDiv.appendChild(createSubredditButton);
    buttonsDiv.appendChild(createPostButton);

    menuDiv.appendChild(buttonsDiv);

    document.body.appendChild(menuDiv);

    openMenuButton.addEventListener("click", function () {
        if (menuDiv.style.display === "none") {
            menuDiv.style.display = "block";
        } else {
            menuDiv.style.display = "none";
        }
    });
});
