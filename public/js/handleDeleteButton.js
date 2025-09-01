function handleDeleteButtonClick({
    selector,
    getDeleteUrl,
    reloadTableId = null,
}) {
    $(document).on("click", selector, function () {
        console.log("Delete clicked, id:", $(this).data("id"));
        const id = $(this).data("id");
        const url = getDeleteUrl(id);

        Swal.fire({
            title: "آیا مطمئن هستید؟",
            text: `آیا می‌خواهید این ریکورد حذف شود؟`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "بله، حذفش کن",
            cancelButtonText: "لغو",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function () {
                    if (reloadTableId) {
                        $(`#${reloadTableId}`)
                            .DataTable()
                            .ajax.reload(null, false);
                    }

                    Swal.fire("حذف شد!", "ریکورد با موفقیت حذف شد.", "success");
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        "خطا!",
                        "حذف انجام نشد. لطفاً دوباره تلاش کنید.",
                        "error"
                    );
                },
            });
        });
    });
}
