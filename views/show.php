<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="/assets/css/main.css">

    <title>Lab 2 - Account</title>
  </head>
  <body>

  <div class="modal fade" id="loginPopup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="loginForm" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
                <div class="error-message"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
   </div>

    <header class="header">
       <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Logo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if ($authId) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/?controller=users&action=logout">Sign out</a>
                            </li>
                        <? else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginPopup">Sign in</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/?controller=users&action=registration">Sign up</a>
                            </li>
                        <? endif; ?>
                    </ul>
                    <form class="d-flex" action="/" method="get">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    </div>
                </div>
            </nav>
       </div>
    </header>

    <main class="main">
        <div class="container">
            <?php if ($ownProfile || $isAdmin) : ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="showForm-container">
                            <h2>Edit profile</h2><br>
                            <form class="showForm" id="showForm">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                                </div>
                                <?php if ($isAdmin && !$ownProfile) : ?>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" name="role" id="role">
                                            <option value="user" <?php if (!$user['is_admin']) echo 'selected'; ?>>User</option>
                                            <option value="admin" <?php if ($user['is_admin']) echo 'selected'; ?>>Admin</option>
                                        </select>
                                    </div>
                                <? endif; ?>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <div class="error-message"></div>
                                <div class="alert alert-success" style="display: none" role="alert">Saved.</div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="showForm-container">
                            <h2>Edit password</h2><br>
                            <form class="showForm" id="showFormPassword">
                                <div class="mb-3">
                                    <label for="oldPassword" class="form-label">Old rassword</label>
                                    <input type="password" class="form-control" id="oldPassword" name="old_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">New password</label>
                                    <input type="password" class="form-control" id="password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rePassword" class="form-label">Repeat rassword</label>
                                    <input type="password" class="form-control" id="rePassword" name="new_password_repeat" required>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <div class="error-message"></div>
                                <div class="alert alert-success" style="display: none" role="alert">Saved.</div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <br>
                        <div class="showForm-container">
                            <h2>Change avatar</h2><br>
                            <label for="" class="form-label">Current avatar:</label><br>
                            <img src="/public/avatars/<?php echo $user['id']; ?>.png" class="img-thumbnail current-avatar" alt="">
                            <form class="showForm" id="showAvatarForm" enctype="multipart/form-data" method="POST" action="/?controller=users&action=updateAvatarAjax">
                                <br>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Select new avatar</label>
                                    <input class="form-control" type="file" id="formFile" name="avatar">
                                </div>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <div class="error-message"></div>
                            </form>
                        </div>
                    </div>
                </div>
            <? else : ?>
                <div class="row">
                    <div class="col-sm-5">
                        <h2><?php echo $user['first_name'].' '.$user['last_name']; ?></h2>
                        <h3 class="user-email">Email: <?php echo $user['email']; ?></h3>
                        <p>Role: <?php if ($user['is_admin']) echo 'Admin'; else echo 'User'; ?></p>
                    </div>
                    <div class="col-sm-2">
                        <img src="/public/avatars/<?php echo $user['id']; ?>.png" class="user-avatar img-thumbnail" alt="">
                    </div>
                </div>
            <? endif; ?>
            <div class="comments-block">
                <br>
                <h2>Comments</h2>
                <?php if (count($comments) < 1) : ?>
                    <p>No one comment...</p>
                <? else : ?>
                    <?php foreach ($comments as $comment) : ?>
                        <div class="comments-item">
                            <img src="/public/avatars/<?php echo $comment['authr_id']; ?>.png" alt="" class="comment-avatar img-thumbnail">
                            <h3 class="comment-name"><?php echo $comment['authr_first_name'].' '.$comment['authr_last_name']; ?></h3>
                            <h4 class="comment-date"><?php echo $comment['date']; ?></h4>
                            <p class="comment-text"><?php echo $comment['text']; ?></p>
                            <?php if ($ownProfile || $isAdmin) : ?>
                                <a href="/?controller=comments&action=update&comment_id=<?php echo $comment['id']; ?>&user_id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="#" class="delete-comment-button btn btn-danger" data-comment-id="<?php echo $comment['id']; ?>">Delete</a>
                            <? endif; ?>
                            <hr>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
            <?php if (!$ownProfile && $authId) : ?>
                <div class="comments-form">
                    <h4>Add Comment</h4>
                    <form class="addCommentForm" id="addCommentForm">
                        <div class="form-group">
                            <label for="comment">Comment text</label><br><br>
                            <textarea class="form-control" name="text" id="comment" rows="3"></textarea>
                        </div><br>
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" name="author_id" value="<?php echo $authId; ?>">
                        <button type="submit" class="btn btn-primary">Add comment</button>
                        <div class="error-message"></div>
                        <div class="alert alert-success" style="display: none" role="alert">
                            Comment has been saved.
                        </div>
                    </form>
                </div>
            <? endif; ?>
        </div>
    </main>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
  </body>
</html>