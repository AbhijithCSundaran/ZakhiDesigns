<div class="container mt-5">
    <h2>Leave a Review</h2>
    <form id="reviewForm">
        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name="email" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Rating</label>
            <select name="rating" class="form-control" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Review</label>
            <textarea name="review" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success">Submit</button>
    </form>
    <div id="reviewResponse" class="mt-3"></div>

    <hr>
    <h3>What others say</h3>
    <?php foreach ($reviews as $rev): ?>
        <div class="card my-2">
            <div class="card-body">
                <strong><?= esc($rev['name']) ?></strong>
                <div><?= str_repeat('★', $rev['rating']) . str_repeat('☆', 5 - $rev['rating']) ?></div>
                <p><?= esc($rev['review']) ?></p>
                <small class="text-muted"><?= date('F d, Y', strtotime($rev['created_at'])) ?></small>
            </div>
        </div>
    <?php endforeach; ?>
</div>
