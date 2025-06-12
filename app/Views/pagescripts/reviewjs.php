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
        window.location.reload();

        // Hide the message after 3 seconds
        setTimeout(() => {
            div.innerHTML = '';
        }, 3000);
    })
    .catch(error => {
        console.error("Error submitting review:", error);
        document.getElementById("reviewResponse").innerHTML = `<div class="alert alert-danger">An unexpected error occurred.</div>`;

        setTimeout(() => {
            document.getElementById("reviewResponse").innerHTML = '';
        }, 3000);
    });
});
</script>
