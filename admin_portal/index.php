<?php
include_once __DIR__.'/../admin_portal/functions/dashboard_function.php';
include_once __DIR__.'/../admin_portal/partials/header.php';
?>
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">Welcome back, <?=$f_name?> !</p>
                <span class="fs-semibold text-muted">Track students activities here.</span>
            </div>
            <div class="btn-list mt-md-0 mt-2">
                <button type="button" class="btn btn-primary btn-wave">
                    <i class="ri-filter-3-fill me-2 align-middle d-inline-block"></i>Filters
                </button>
                <button type="button" class="btn btn-outline-secondary btn-wave">
                    <i class="ri-upload-cloud-line me-2 align-middle d-inline-block"></i>Export
                </button>
            </div>
        </div>

        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-9 col-xl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Deals Statistics
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <div>
                                        <input class="form-control form-control-sm" type="text" placeholder="Search Here" aria-label=".form-control-sm example">
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">New</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover border table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="row" class="ps-4"><input class="form-check-input" type="checkbox" id="checkboxNoLabel1" value="" aria-label="..."></th>
                                            <th scope="col">Student Name</th>
                                            <th scope="col">Reg Number</th>
                                            <th scope="col">Previous Class</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Reg Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($row = $get_new_users_result->fetch_assoc()) {
                                            $first_name = $row['firstname'];
                                            $last_name = $row['lastname'];
                                            $gender = $row['gender'];
                                            $state = $row['state'];
                                            $last_class_passed = $row['last_class_passed'];
                                            $passport = $row['passport'];
                                            $reg_number = $row['reg_number'];
                                            $date_of_reg = $row['date_of_reg'];

                                            $full_name = $first_name . ' ' . $last_name;

                                            // Generate a unique ID for the badge using the reg_number or another unique field
//                                            $badgeId = 'badge-state-' . $reg_number;
                                            $badgeId = $reg_number;
                                            ?>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input" type="checkbox" id="checkboxNoLabel2" value="" aria-label="..."></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                <span class="avatar avatar-sm me-2 avatar-rounded">
                    <img src="https://portal.tmit.com.ng/<?= $passport ?>" alt="img">
                </span><?= $full_name ?>
                                                    </div>
                                                </td>
                                                <td><?= $reg_number ?></td>
                                                <td><?= $last_class_passed ?></td>
                                                <td>
                                                    <span id="<?= $badgeId ?>" class="badge bg-info-transparent"><?= $state ?></span>
                                                </td>

                                                <script>
                                                    // JavaScript array of possible badge classes
                                                    const badgeClasses = [
                                                        'badge bg-info-transparent',
                                                        'badge bg-success-transparent',
                                                        'badge bg-danger-transparent',
                                                        'badge bg-primary-transparent'
                                                    ];

                                                    // Get the badge element by its unique ID
                                                    const badgeElement = document.getElementById("<?= $badgeId ?>");

                                                    // Randomly select a class from the badgeClasses array
                                                    const randomBadgeClass = badgeClasses[Math.floor(Math.random() * badgeClasses.length)];

                                                    // Apply the selected class to the badge element
                                                    badgeElement.className = randomBadgeClass;
                                                </script>

                                                <td><?= $date_of_reg ?></td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-success-light"><i class="ri-download-2-line"></i></a>
                                                        <a onclick="location.href='https://portal.tmit.com.ng/resources/view/modules.php?view_students'" aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-primary-light"><i class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                    <div>
                                        Showing 5 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i>
                                    </div>
                                    <div class="ms-auto">
                                        <nav aria-label="Page navigation" class="pagination-style-4">
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="javascript:void(0);">
                                                        Prev
                                                    </a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                                <li class="page-item">
                                                    <a class="page-link text-primary" href="javascript:void(0);">
                                                        next
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->

    </div>
</div>
<!-- End::app-content -->
<?php
include_once __DIR__.'/../admin_portal/partials/footer.php';
?>