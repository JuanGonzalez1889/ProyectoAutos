
<title><?php echo e($title); ?></title>
<meta name="description" content="<?php echo e($description); ?>">
<?php if($keywords): ?>
    <meta name="keywords" content="<?php echo e($keywords); ?>">
<?php endif; ?>


<meta property="og:type" content="<?php echo e($type); ?>">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image" content="<?php echo e($image); ?>">
<meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">


<meta name="twitter:card" content="<?php echo e($twitterCard); ?>">
<meta name="twitter:url" content="<?php echo e($url); ?>">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<meta name="twitter:image" content="<?php echo e($image); ?>">


<meta name="robots" content="index, follow">
<meta name="author" content="<?php echo e(config('app.name')); ?>">
<link rel="canonical" href="<?php echo e($url); ?>">
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/components/seo.blade.php ENDPATH**/ ?>