<?php
// utils/auth.util.php

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function getLoggedInUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}