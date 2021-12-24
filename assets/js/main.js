$(document).ready(function() {
    regForm();
    loginForm();
    commentForm();
    commentEditForm();
    deleteCommentButton();
    addUserForm();
    showForm();
    showFormPassword();
    deleteUserBtn();
});


function deleteUserBtn() {
    $('.btnUserDelete').click(function() {
        const userId = $(this).attr('data-user-id');

        if (confirm("Are you really want to delete this user?")) {
            $.ajax({
                type: "POST",
                url: "/?controller=admin&action=deleteUserAjax",
                data: 'id=' + userId
            }).done(function(d) {
                const res = JSON.parse(d);

                if (res.status == 'success') {
                    window.location = '/';
                } else {
                    alert(res.msg);
                }
            });
        }

		return false;
    });
}

function regForm() {

    $('#regForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');

		$.ajax({
			type: "POST",
			url: "/?controller=users&action=registrationAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                window.location = '/';
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });

}

function showForm() {
    $('#showForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');
        $('.alert', th).css('display', 'none');

		$.ajax({
			type: "POST",
			url: "/?controller=users&action=updateProfileAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                $('.alert', th).css('display', 'block');
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });
}

function showFormPassword() {
    $('#showFormPassword').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');
        $('.alert', th).css('display', 'none');

		$.ajax({
			type: "POST",
			url: "/?controller=users&action=updatePasswordAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                $('.alert', th).css('display', 'block');
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });
}

function loginForm() {
    $('#loginForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');

		$.ajax({
			type: "POST",
			url: "/?controller=users&action=loginAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                window.location = '/';
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });
}

function commentForm() {
    $('#addCommentForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');

		$.ajax({
			type: "POST",
			url: "/?controller=comments&action=insertAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                $('.alert', th).css('display', 'block');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });
}

function commentEditForm() {
    $('#editCommentForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');
        $('.alert', th).css('display', 'none');

		$.ajax({
			type: "POST",
			url: "/?controller=comments&action=updateAjax",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                $('.alert', th).css('display', 'block');
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });
}

function deleteCommentButton() {
    $('.delete-comment-button').click(function(e) {
        e.preventDefault();
        const comment_id = $(this).attr('data-comment-id');

        if (confirm("Are you really want to delete this comment?")) {
            $.ajax({
                type: "POST",
                url: "/?controller=comments&action=deleteAjax",
                data: "comment_id=" + comment_id
            }).done(function(d) {
                const res = JSON.parse(d);
    
                if (res.status == 'success') {
                    location.reload();
                } else {
                    alert(res.msg);
                }
            });
        }
        
		return false;
    });
}

function addUserForm() {

    $('#addUserForm').submit(function() {
        const th = $(this);
        const errorMessageTag = $('.error-message', th);
        errorMessageTag.text('');

		$.ajax({
			type: "POST",
			url: "/?controller=users&action=registrationAjax&auth=false",
			data: th.serialize()
		}).done(function(d) {
			const res = JSON.parse(d);

            if (res.status == 'success') {
                window.location = '/';
            } else {
                errorMessageTag.text(res.msg);
            }
		});
		return false;
    });

}