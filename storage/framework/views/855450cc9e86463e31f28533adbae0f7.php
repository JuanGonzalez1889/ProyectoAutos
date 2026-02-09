<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    
    <?php if (! empty(trim($__env->yieldContent('seo')))): ?>
        <?php echo $__env->yieldContent('seo'); ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginala2d9072d59b69a761b60324b3706ddf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2d9072d59b69a761b60324b3706ddf1 = $attributes; } ?>
<?php $component = App\View\Components\Seo::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Seo::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $attributes = $__attributesOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $component = $__componentOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__componentOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
    <?php endif; ?>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    
    <?php if (isset($component)) { $__componentOriginalea2dce4014fb9bd77432d0a2cf5dc69b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalea2dce4014fb9bd77432d0a2cf5dc69b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.analytics','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('analytics'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalea2dce4014fb9bd77432d0a2cf5dc69b)): ?>
<?php $attributes = $__attributesOriginalea2dce4014fb9bd77432d0a2cf5dc69b; ?>
<?php unset($__attributesOriginalea2dce4014fb9bd77432d0a2cf5dc69b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalea2dce4014fb9bd77432d0a2cf5dc69b)): ?>
<?php $component = $__componentOriginalea2dce4014fb9bd77432d0a2cf5dc69b; ?>
<?php unset($__componentOriginalea2dce4014fb9bd77432d0a2cf5dc69b); ?>
<?php endif; ?>
</head>
<body class="bg-[hsl(var(--background))] text-[hsl(var(--foreground))] lg:overflow-hidden">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/layouts/guest.blade.php ENDPATH**/ ?>