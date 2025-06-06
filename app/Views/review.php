<div class="container mt-5">
    <h2>Leave a Review</h2>
    <form id="reviewForm" method="post" action="<?= base_url('review/submit') ?>">
        <input type="hidden" name="pr_Id" value="<?= esc($product['pr_Id']) ?>" />
        <div class="form-group col-md-6">
            <label>Name</label>
            <input name="name" class="form-control" required />
        </div>
        <div class="form-group col-md-6">
            <label>Email</label>
            <input name="email" class="form-control" required />
        </div>
        <div class="form-group col-md-6">
            <label>Rating</label>
            <select name="rating" class="form-control" required>
                <option value="">Select Rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Review</label>
            <textarea name="review" class="form-control" required></textarea>
        </div>
        <div class="form-group col-md-6">
		<div> &nbsp;'</div>
         <div class="text-end">
		 <button type="submit" class="btn btn-success">Submit</button>
		</div>  
        </div>
		
    </form>

    <div id="reviewResponse" class="mt-3"></div>

    <hr>
    <h3>What others say</h3>
    <div class="row">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="col-md-6">
                    <div class="card my-2">
                        <div class="card-body">
                            <strong><?= esc($rev['name']) ?></strong>
                            <div><?= str_repeat('★', $rev['rating']) . str_repeat('☆', 5 - $rev['rating']) ?></div>
                            <p><?= esc($rev['review']) ?></p>
                            <small class="text-muted"><?= date('F d, Y', strtotime($rev['created_at'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">No reviews yet.</p>
        <?php endif; ?>
    </div>
</div>
