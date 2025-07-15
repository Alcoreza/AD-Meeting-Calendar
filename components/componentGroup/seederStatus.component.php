<?php
function renderSeederStatus(string $seederStatus, string $migrateStatus): void
{
    ?>
    <div class="status-section">
        <h3>🛠 Seeder & Migrator Status</h3>
        <p><strong>Seeder:</strong> <?= $seederStatus ?></p>
        <p><strong>Migrator:</strong> <?= $migrateStatus ?></p>
    </div>
    <?php
}
