<?php
function renderDbStatus(string $mongoStatus, string $pgStatus): void
{
    ?>
    <div class="status-section">
        <h3>📊 Database Status</h3>
        <p><strong>MongoDB:</strong> <?= $mongoStatus ?></p>
        <p><strong>PostgreSQL:</strong> <?= $pgStatus ?></p>
    </div>
    <?php
}