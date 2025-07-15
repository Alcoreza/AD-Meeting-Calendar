<?php
function renderAuthBlock(?array $user): void
{
    ?>
    <div class="status-section">
        <?php if (!$user): ?>
            <a href="/pages/login/index.php"><button>Login</button></a>
        <?php else: ?>
            <p>👋 Hello, <strong><?= htmlspecialchars($user['first_name']) ?></strong> (<?= htmlspecialchars($user['role']) ?>)
            </p>
            <form method="POST" action="/handlers/logout.handler.php">
                <button type="submit">Logout</button>
            </form>
        <?php endif; ?>
    </div>
    <?php
}
