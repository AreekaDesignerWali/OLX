<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>OLX Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #002f34;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .nav-btns a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            transition: 0.3s;
        }
        .nav-btns a:hover {
            color: #23e5db;
        }
        .container {
            padding: 40px;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 20px;
            background-color: #002f34;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
        }
        button:hover {
            background-color: #006064;
        }
    </style>
</head>
<body>

<header>
    <h1>OLX Clone</h1>
    <div class="nav-btns">
        <a href="javascript:void(0)" onclick="redirect('signup.php')">Signup</a>
        <a href="javascript:void(0)" onclick="redirect('login.php')">Login</a>
    </div>
</header>

<div class="container">
    <form onsubmit="event.preventDefault(); search()">
        <input type="text" id="searchInput" placeholder="Search ads..." />
        <button type="submit">Search</button>
    </form>
</div>

<script>
    function redirect(page) {
        window.location.href = page;
    }

    function search() {
        let query = document.getElementById('searchInput').value.trim();
        if(query !== "") {
            window.location.href = 'search.php?q=' + encodeURIComponent(query);
        }
    }
</script>

</body>
</html>
