// texyla
$.texyla.setDefaults({
	previewPath: "{{$texylaPreviewPath}}",
	baseDir: "{{$baseUri}}",
	iconPath: "{{$baseUri}}js/texyla/icons/%var%.png"
});

// texyla
$("textarea.texyla").livequery(function () {
	$(this).texyla({
		toolbar: [
			"bold", "italic",
			null,
			"ul", "ol",
			null,
			"link",
			null,
			"syntax"
		],
		bottomLeftToolbar: ['preview', 'edit', 'submit'],
		bottomRightEditToolbar: [],
		bottomRightPreviewToolbar: [],
		padding: 0
	});
});