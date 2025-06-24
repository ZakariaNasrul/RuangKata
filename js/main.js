(function ($) {
  "use strict";

  // Spinner
  var spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner(0);

  // Fixed Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".sticky-top").addClass("shadow-sm").css("top", "0px");
    } else {
      $(".sticky-top").removeClass("shadow-sm").css("top", "-200px");
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Latest-news-carousel
  $(".latest-news-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 2000,
    center: false,
    dots: true,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      '<i class="bi bi-arrow-left"></i>',
      '<i class="bi bi-arrow-right"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
      1200: {
        items: 4,
      },
    },
  });

  // What's New carousel
  $(".whats-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 2000,
    center: false,
    dots: true,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      '<i class="bi bi-arrow-left"></i>',
      '<i class="bi bi-arrow-right"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 2,
      },
      1200: {
        items: 2,
      },
    },
  });

  // Modal Video
  $(document).ready(function () {
    var $videoSrc;
    $(".btn-play").click(function () {
      $videoSrc = $(this).data("src");
    });
    console.log($videoSrc);

    $("#videoModal").on("shown.bs.modal", function (e) {
      $("#video").attr(
        "src",
        $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"
      );
    });

    $("#videoModal").on("hide.bs.modal", function (e) {
      $("#video").attr("src", $videoSrc);
    });
  });
})(jQuery);

// JavaScript untuk menampilkan modal edit ketika parameter 'edit' ada di URL
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("edit")) {
    const articleModal = new bootstrap.Modal(
      document.getElementById("articleModal")
    );
    articleModal.show();
  }

  // Update modal title and form action when "Tambah Artikel" button is clicked
  document
    .querySelector('.btn-primary[data-bs-target="#articleModal"]')
    .addEventListener("click", function () {
      document.getElementById("articleModalLabel").textContent =
        "Tambah Artikel";
      document.getElementById("article-id").value = "";
      document.getElementById("current-picture").value = "";
      document.getElementById("title").value = "";
      document.getElementById("content").value = "";
      // Hapus pratinjau gambar yang ada
      const currentPicturePreview = document.querySelector(
        ".current-picture-preview"
      );
      if (currentPicturePreview) {
        currentPicturePreview.remove();
      }
      document.getElementById("picture").value = ""; // Kosongkan input file

      // Hapus centang semua penulis dan kategori
      document
        .querySelectorAll('input[name="authors[]"]')
        .forEach((checkbox) => {
          checkbox.checked = false;
        });
      document
        .querySelectorAll('input[name="categories[]"]')
        .forEach((checkbox) => {
          checkbox.checked = false;
        });
    });
});
// This sample still does not showcase all CKEditor&nbsp;5 features (!)
// Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
CKEDITOR.ClassicEditor.create(document.getElementById("isi"), {
  // https://ckeditor.com/docs/ckeditor5/latest/getting-started/setup/toolbar/toolbar.html#extended-toolbar-configuration-format
  toolbar: {
    items: [
      "exportPDF",
      "exportWord",
      "|",
      "findAndReplace",
      "selectAll",
      "|",
      "heading",
      "|",
      "bold",
      "italic",
      "strikethrough",
      "underline",
      "code",
      "subscript",
      "superscript",
      "removeFormat",
      "|",
      "bulletedList",
      "numberedList",
      "todoList",
      "|",
      "outdent",
      "indent",
      "|",
      "undo",
      "redo",
      "-",
      "fontSize",
      "fontFamily",
      "fontColor",
      "fontBackgroundColor",
      "highlight",
      "|",
      "alignment",
      "|",
      "link",
      "uploadImage",
      "blockQuote",
      "insertTable",
      "mediaEmbed",
      "codeBlock",
      "htmlEmbed",
      "|",
      "specialCharacters",
      "horizontalLine",
      "pageBreak",
      "|",
      "textPartLanguage",
      "|",
      "sourceEditing",
    ],
    shouldNotGroupWhenFull: true,
  },
  // Changing the language of the interface requires loading the language file using the <script> tag.
  // language: 'es',
  list: {
    properties: {
      styles: true,
      startIndex: true,
      reversed: true,
    },
  },
  // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
  heading: {
    options: [
      {
        model: "paragraph",
        title: "Paragraph",
        class: "ck-heading_paragraph",
      },
      {
        model: "heading1",
        view: "h1",
        title: "Heading 1",
        class: "ck-heading_heading1",
      },
      {
        model: "heading2",
        view: "h2",
        title: "Heading 2",
        class: "ck-heading_heading2",
      },
      {
        model: "heading3",
        view: "h3",
        title: "Heading 3",
        class: "ck-heading_heading3",
      },
      {
        model: "heading4",
        view: "h4",
        title: "Heading 4",
        class: "ck-heading_heading4",
      },
      {
        model: "heading5",
        view: "h5",
        title: "Heading 5",
        class: "ck-heading_heading5",
      },
      {
        model: "heading6",
        view: "h6",
        title: "Heading 6",
        class: "ck-heading_heading6",
      },
    ],
  },
  // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
  placeholder: "Mulai tulis di sini...",
  // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
  fontFamily: {
    options: [
      "default",
      "Arial, Helvetica, sans-serif",
      "Courier New, Courier, monospace",
      "Georgia, serif",
      "Lucida Sans Unicode, Lucida Grande, sans-serif",
      "Tahoma, Geneva, sans-serif",
      "Times New Roman, Times, serif",
      "Trebuchet MS, Helvetica, sans-serif",
      "Verdana, Geneva, sans-serif",
    ],
    supportAllValues: true,
  },
  // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
  fontSize: {
    options: [10, 12, 14, "default", 18, 20, 22],
    supportAllValues: true,
  },
  // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
  // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
  htmlSupport: {
    allow: [
      {
        name: /.*/,
        attributes: true,
        classes: true,
        styles: true,
      },
    ],
  },
  // Be careful with enabling previews
  // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
  htmlEmbed: {
    showPreviews: false,
  },
  // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
  link: {
    decorators: {
      addTargetToExternalLinks: true,
      defaultProtocol: "https://",
      toggleDownloadable: {
        mode: "manual",
        label: "Downloadable",
        attributes: {
          download: "file",
        },
      },
    },
  },
  // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
  mention: {
    feeds: [
      {
        marker: "@",
        feed: [
          "@apple",
          "@bears",
          "@brownie",
          "@cake",
          "@cake",
          "@candy",
          "@canes",
          "@chocolate",
          "@cookie",
          "@cotton",
          "@cream",
          "@cupcake",
          "@danish",
          "@donut",
          "@dragée",
          "@fruitcake",
          "@gingerbread",
          "@gummi",
          "@ice",
          "@jelly-o",
          "@liquorice",
          "@macaroon",
          "@marzipan",
          "@oat",
          "@pie",
          "@plum",
          "@pudding",
          "@sesame",
          "@snaps",
          "@soufflé",
          "@sugar",
          "@sweet",
          "@topping",
          "@wafer",
        ],
        minimumCharacters: 1,
      },
    ],
  },
  // The "superbuild" contains more premium features that require additional configuration, disable them below.
  // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
  removePlugins: [
    // These two are commercial, but you can try them out without registering to a trial.
    // 'ExportPdf',
    // 'ExportWord',
    "AIAssistant",
    "CKBox",
    "CKFinder",
    "EasyImage",
    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
    // Storing images as Base64 is usually a very bad idea.
    // Replace it on production website with other solutions:
    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
    // 'Base64UploadAdapter',
    "MultiLevelList",
    "RealTimeCollaborativeComments",
    "RealTimeCollaborativeTrackChanges",
    "RealTimeCollaborativeRevisionHistory",
    "PresenceList",
    "Comments",
    "TrackChanges",
    "TrackChangesData",
    "RevisionHistory",
    "Pagination",
    "WProofreader",
    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
    "MathType",
    // The following features require additional license.
    "SlashCommand",
    "Template",
    "DocumentOutline",
    "FormatPainter",
    "TableOfContents",
    "PasteFromOfficeEnhanced",
    "CaseChange",
  ],
});
