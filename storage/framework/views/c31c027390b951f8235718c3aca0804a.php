<?php if(config('services.google_analytics.measurement_id') && !app()->environment('local')): ?>
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('services.google_analytics.measurement_id')); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?php echo e(config('services.google_analytics.measurement_id')); ?>', {
        'send_page_view': true,
        'anonymize_ip': true
    });

    // Custom event tracking functions
    window.trackEvent = function(eventName, eventParams = {}) {
        gtag('event', eventName, eventParams);
    };

    // Track vehicle view
    window.trackVehicleView = function(vehicleId, vehicleName) {
        gtag('event', 'view_item', {
            'event_category': 'Vehicle',
            'event_label': vehicleName,
            'value': vehicleId
        });
    };

    // Track lead submission
    window.trackLeadSubmission = function(source) {
        gtag('event', 'generate_lead', {
            'event_category': 'Lead',
            'event_label': source,
            'value': 1
        });
    };

    // Track subscription purchase
    window.trackSubscriptionPurchase = function(plan, value, currency) {
        gtag('event', 'purchase', {
            'transaction_id': 'SUB_' + Date.now(),
            'value': value,
            'currency': currency,
            'items': [{
                'item_id': plan,
                'item_name': 'Subscription Plan: ' + plan,
                'item_category': 'Subscription',
                'price': value,
                'quantity': 1
            }]
        });
    };
</script>
<?php endif; ?>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/components/analytics.blade.php ENDPATH**/ ?>