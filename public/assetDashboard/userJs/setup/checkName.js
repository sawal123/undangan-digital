$(document).ready(function () {
    var checkTimer = null;
    var lastValidatedSlug = null;
    var isManualSlug = false;

    // Helper: generate URL-friendly slug from title
    function generateSlug(text) {
        if (!text) return "";
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/&/g, "dan")
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-")
            .replace(/^-+|-+$/g, "");
    }

    // Helper: check inputs to toggle submit button
    function checkInputs(isSlugValid) {
        var title = $("#title").val() ? $("#title").val().trim() : "";
        var slug = $("#basic-url").val() ? $("#basic-url").val().trim() : "";

        if (title !== "" && slug !== "" && isSlugValid !== false) {
            $("#next").prop("disabled", false);
        } else {
            $("#next").prop("disabled", true);
        }
    }

    // Perform AJAX slug check with debouncing
    function validateSlug(slug) {
        slug = (slug || "").trim();

        if (slug === "") {
            $("#nameValidationMessage").html("");
            checkInputs(false);
            return;
        }

        $("#nameValidationMessage").html(
            '<small class="text-muted"><i class="mdi mdi-loading mdi-spin"></i> Memeriksa ketersediaan slug...</small>'
        );

        $.ajax({
            url: typeof checkNameUrl !== "undefined" ? checkNameUrl : "/check-name",
            method: "POST",
            data: { name: slug },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                lastValidatedSlug = slug;
                if (response.success) {
                    $("#nameValidationMessage").html(
                        '<small class="text-success"><i class="mdi mdi-check-circle"></i> ' +
                            response.message +
                            "</small>"
                    );
                    checkInputs(true);
                } else {
                    $("#nameValidationMessage").html(
                        '<small class="text-danger"><i class="mdi mdi-alert-circle"></i> ' +
                            response.message +
                            "</small>"
                    );
                    checkInputs(false);
                }
            },
            error: function (xhr) {
                console.error("Slug validation error:", xhr);
            },
        });
    }

    function scheduleSlugValidation(slug) {
        clearTimeout(checkTimer);
        checkTimer = setTimeout(function () {
            validateSlug(slug);
        }, 250);
    }

    // Auto-generate slug when #title is typed
    $("#title").on("input", function () {
        var titleVal = $(this).val();

        // If user hasn't manually customized the slug, or if slug is empty, auto-generate
        if (!isManualSlug || $("#basic-url").val().trim() === "") {
            var autoSlug = generateSlug(titleVal);
            $("#basic-url").val(autoSlug);
            scheduleSlugValidation(autoSlug);
        } else {
            checkInputs();
        }
    });

    // When user types directly into #basic-url
    $("#basic-url").on("input", function () {
        var currentVal = $(this).val();
        var sanitized = currentVal
            .toLowerCase()
            .replace(/&/g, "dan")
            .replace(/[^a-z0-9-]/g, "-")
            .replace(/-+/g, "-");

        if (currentVal !== sanitized) {
            $(this).val(sanitized);
        }

        if (sanitized.trim() === "") {
            isManualSlug = false;
        } else {
            isManualSlug = true;
        }

        scheduleSlugValidation(sanitized);
    });

    // Dynamic hints based on event type selection
    function updateEventHints() {
        var eventTypeSelect = $("#event_type_id");
        if (!eventTypeSelect.length) return;

        var selectedText = eventTypeSelect.find("option:selected").text().trim().toLowerCase();
        var hintContainer = $("#titleHint");
        var titleInput = $("#title");

        if (selectedText.includes("ulang tahun") || selectedText.includes("birthday")) {
            if (hintContainer.length) {
                hintContainer.html('Contoh : <strong>Arash Nayaka</strong> atau <strong>Keisha 7th</strong>');
            }
            titleInput.attr("placeholder", "Contoh: Arash Nayaka");
        } else if (selectedText.includes("tunangan") || selectedText.includes("engagement")) {
            if (hintContainer.length) {
                hintContainer.html('Contoh : <strong>Rian & Rina</strong>');
            }
            titleInput.attr("placeholder", "Contoh: Rian & Rina");
        } else if (selectedText.includes("pengajian") || selectedText.includes("event")) {
            if (hintContainer.length) {
                hintContainer.html('Contoh : <strong>Pengajian Akbar</strong> atau <strong>Syukuran Kelulusan</strong>');
            }
            titleInput.attr("placeholder", "Contoh: Pengajian Akbar");
        } else {
            if (hintContainer.length) {
                hintContainer.html('Contoh : <strong>Hendra & Heni</strong>');
            }
            titleInput.attr("placeholder", "Harry & Nia");
        }
    }

    $("#event_type_id").on("change", function () {
        updateEventHints();
    });

    // Run on load if pre-filled
    updateEventHints();
    var initialSlug = $("#basic-url").val() ? $("#basic-url").val().trim() : "";
    if (initialSlug !== "") {
        validateSlug(initialSlug);
    } else {
        var initialTitle = $("#title").val() ? $("#title").val().trim() : "";
        if (initialTitle !== "") {
            var gen = generateSlug(initialTitle);
            $("#basic-url").val(gen);
            validateSlug(gen);
        }
    }
});
