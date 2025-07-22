<?php if (!empty($reviews)): ?>
    <?php foreach (array_chunk($reviews, 2) as $reviewPair): ?>
        <div class="row mb-4">
            <?php foreach ($reviewPair as $rev): ?>
                <div class="col-md-6">
                    <h6 class="card-title mb-1"><?= esc($rev['name']) ?></h6>
                    <div class="mb-2 text-warning" style="font-size: 1.2em;">
                        <?= str_repeat('★', (int) $rev['rating']) . str_repeat('☆', 5 - (int) $rev['rating']) ?>
                        <span style="font-size:12px; color:#000;">Posted on <?= date('d M Y', strtotime($rev['created_at'])) ?></span>
                    </div>
                    <p class="card-text"><?= esc($rev['review']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
