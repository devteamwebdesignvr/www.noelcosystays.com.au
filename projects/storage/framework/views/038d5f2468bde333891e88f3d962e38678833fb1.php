<!-- Required meta tags -->
<meta charset="utf-8">
<title><?php echo $__env->yieldContent('title'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
<meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
<meta name="robots" content="index, follow"/>
<meta name="coverage" content="Worldwide" />

<link rel="icon" href="<?php echo e(asset($setting_data['favicon'] ?? 'front/images/favicon.png')); ?>"  />
<meta property="og:site_name" content="Asif" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>" />
<meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>" />
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:domain" content="<?php echo e(url()->current()); ?>" />
<meta name="twitter:title" content="<?php echo $__env->yieldContent('title'); ?>" />
<meta name="twitter:description" content="<?php echo $__env->yieldContent('description'); ?>" />

<?php if(isset($gaurav_blog_data)): ?>
	<meta name="twitter:image" content="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.webp')); ?>" />
  	<meta property="og:image" content="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.webp')); ?>" />
<?php else: ?>
	<meta name="twitter:image" content="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.webp')); ?>" />
  	<meta property="og:image" content="<?php echo e(asset($setting_data['header_logo'] ?? 'front/images/logo.webp')); ?>" />
  	
<?php endif; ?>
<link href="<?php echo e(url()->current()); ?>" rel="canonical">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "<?php echo $__env->yieldContent('title'); ?>",
  "url": "<?php echo e(url('/')); ?>",
  "logo": "<?php echo e(asset($setting_data['favicon'] ?? 'front/images/favicon.png')); ?>",
  "description": "<?php echo $__env->yieldContent('description'); ?>",
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": " contact us",
    "telephone":"<?php echo e($setting_data['mobile']); ?>",
    "email":"<?php echo e($setting_data['email']); ?>"
  },
  "sameAs": [

    "<?php echo e($setting_data['facebook']); ?>"
  ]
}
</script>
<link href="<?php echo e(url()->current()); ?>/" rel="canonical">

<?php echo $__env->make("front.layouts.css", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent("css"); ?><?php /**PATH /home/webdesignvrvr-lisa/htdocs/lisa.webdesignvrvr.com/projects/resources/views/front/layouts/head.blade.php ENDPATH**/ ?>