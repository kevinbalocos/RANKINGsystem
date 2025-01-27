function updateFileStatus(fileId, status) {
    Swal.fire({
        title: `Are you sure you want to ${status} this file?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('conAdmin/updateFileStatus'); ?>",
                method: "POST",
                data: { file_id: fileId, status: status },
                success: function (response) {
                    const result = JSON.parse(response);
                    Swal.fire({
                        icon: result.status === 'success' ? 'success' : 'error',
                        title: result.message
                    }).then(() => location.reload());
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.'
                    });
                }
            });
        }
    });
}

function deleteFile(fileId) {
    Swal.fire({
        title: "Are you sure you want to delete this file?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('conAdmin/deleteFile'); ?>",
                method: "POST",
                data: { file_id: fileId },
                success: function (response) {
                    const result = JSON.parse(response);
                    Swal.fire({
                        icon: result.status === 'success' ? 'success' : 'error',
                        title: result.message
                    }).then(() => location.reload());
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.'
                    });
                }
            });
        }
    });
}

function bulkApprove() {
    Swal.fire({
        title: "Are you sure you want to approve all pending files?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const fileIds = getSelectedFileIds();
            if (fileIds.length > 0) {
                $.ajax({
                    url: "<?php echo base_url('conAdmin/bulkUpdateFileStatus'); ?>",
                    method: "POST",
                    data: { file_ids: fileIds, status: 'approved' },
                    success: function (response) {
                        const result = JSON.parse(response);
                        Swal.fire({
                            icon: result.status === 'success' ? 'success' : 'error',
                            title: result.message
                        }).then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'No pending files selected.'
                });
            }
        }
    });
}

function bulkDeny() {
    Swal.fire({
        title: "Are you sure you want to deny all pending files?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const fileIds = getSelectedFileIds();
            if (fileIds.length > 0) {
                $.ajax({
                    url: "<?php echo base_url('conAdmin/bulkUpdateFileStatus'); ?>",
                    method: "POST",
                    data: { file_ids: fileIds, status: 'denied' },
                    success: function (response) {
                        const result = JSON.parse(response);
                        Swal.fire({
                            icon: result.status === 'success' ? 'success' : 'error',
                            title: result.message
                        }).then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'No pending files selected.'
                });
            }
        }
    });
}

function bulkDelete() {
    Swal.fire({
        title: "Are you sure you want to delete all selected files?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const fileIds = getSelectedFileIds();
            if (fileIds.length > 0) {
                $.ajax({
                    url: "<?php echo base_url('conAdmin/bulkDeleteFiles'); ?>",
                    method: "POST",
                    data: { file_ids: fileIds },
                    success: function (response) {
                        const result = JSON.parse(response);
                        Swal.fire({
                            icon: result.status === 'success' ? 'success' : 'error',
                            title: result.message
                        }).then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'No files selected.'
                });
            }
        }
    });
}
function getSelectedFileIds() {
    const checkboxes = document.querySelectorAll('.file-checkbox:checked');
    return Array.from(checkboxes).map(checkbox => checkbox.value);
}

function toggleSelectAll() {
    const masterCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.file-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = masterCheckbox.checked);
}

$.ajax({
    url: "<?php echo base_url('conAdmin/updateFileStatus'); ?>",
    method: "POST",
    data: { file_id: fileId, status: status },
    success: function (response) {
        const result = JSON.parse(response);
        Swal.fire({
            icon: result.status === 'success' ? 'success' : 'error',
            title: result.message
        }).then(() => {
            if (result.status === 'success') location.reload();
        });
    },
    error: function (xhr, status, error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'An error occurred. Please check the console for details.'
        });
    }
});

function confirmDownload(filePath, fileName) {
    Swal.fire({
        title: `Download ${fileName}?`,
        text: "Are you sure you want to download this file?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Download",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a hidden anchor element to trigger download
            const link = document.createElement('a');
            link.href = filePath;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire({
                icon: "success",
                title: "Download started",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

