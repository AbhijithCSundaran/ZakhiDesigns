<script>
document.querySelector("#contactForm").addEventListener("submit", function(e) {
	e.preventDefault();

	const form = e.target;
	const formData = new FormData(form);

	fetch("<?= base_url('contact/submit') ?>", {
		method: "POST",
		body: formData,
		headers: {
			"X-Requested-With": "XMLHttpRequest"
		}
	})
	.then(response => response.json())
	.then(data => {
		const responseDiv = document.getElementById("formResponse");
		if (data.status === 'success') {
			form.reset();
			responseDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
		} else {
			responseDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
		}
	})
	.catch(error => {
		document.getElementById("formResponse").innerHTML =
			`<div class="alert alert-danger">Something went wrong.</div>`;
	});
});
</script>
