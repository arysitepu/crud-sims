<?= $this->include('template/header') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        
        <!-- sidebar -->
        <?= $this->include('template/sidebar') ?>
        <!-- endsidebar -->

        <!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<?= $this->include('template/topbar') ?>
<!-- content -->
   <?= $this->renderSection('content') ?>
<!-- content -->
</div>
<!-- End of Main Content -->

<?= $this->include('template/footer') ?>