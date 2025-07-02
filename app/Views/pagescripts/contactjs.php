<script>
document.querySelector("#contactForm").addEventListener("submit", function(e) {
	e.preventDefault();

	const form = e.target;
	const formData = new FormData(form);

	const name = formData.get("fullname").trim();
	const phone = formData.get("contact_no").trim();
	const email = formData.get("email").trim();
	const message = formData.get("message").trim();
	const responseDiv = document.getElementById("formResponse");

	// === VALIDATION ===
	const nameRegex = /^[a-zA-Z\s]+$/;
	const phoneRegex = /^\d{7,15}$/;

	if (!nameRegex.test(name)) {
		showMessage("Name Must Contain Only Letters And Spaces.", "danger");
		return;
	}

	if (!phoneRegex.test(phone)) {
		showMessage("Contact Number Must Be Between 7 To 15 Digits.", "danger");
		return;
	}

	if (email === '' || !email.includes("@")) {
		showMessage("Enter A Valid Email Address.", "danger");
		return;
	}

	if (message === '') {
		showMessage("Message Cannot Be Empty.", "danger");
		return;
	}

	// === SUBMIT ===
	fetch("<?= base_url('contact/submit') ?>", {
		method: "POST",
		body: formData,
		headers: {
			"X-Requested-With": "XMLHttpRequest"
		}
	})
	.then(response => response.json())
	.then(data => {
		if (data.status === '1') {
			form.reset();
			showMessage(data.message, "success");
		} else {
			showMessage(data.message, "danger");
		}
	})
	.catch(error => {
		showMessage("Something Went Wrong. Please Try Again Later.", "danger");
	});

	// === Helper: Show Message, Scroll to Top, and Auto-hide ===
	function showMessage(msg, type) {
		responseDiv.innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
		window.scrollTo({ top: 0, behavior: "smooth" });
		setTimeout(() => {
			responseDiv.innerHTML = "";
		}, 5000); // 5 seconds
	}
});
</script>
