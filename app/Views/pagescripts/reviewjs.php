<script>
document.getElementById("reviewForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch("<?= base_url('review/submit') ?>", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(res => res.json())
    .then(data => {
        const div = document.getElementById("reviewResponse");
        div.innerHTML = `<div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
        if (data.status === 'success') form.reset();
    });
});
</script>
