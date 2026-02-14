<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AutoWeb Pro - La plataforma todo-en-uno para gestionar tu inventario, conectar con clientes y vender más autos sin complicaciones técnicas ni código.">
    <title><?php echo $__env->yieldContent('title', 'AutoWeb Pro - Tu concesionaria online en minutos'); ?></title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#020617',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
        }
        
        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Button Gradient */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        /* Hover Glow Effect */
        .hover-glow {
            transition: all 0.3s ease;
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            border-color: rgba(59, 130, 246, 0.6);
        }
        
        /* Smooth Transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        /* Soft Float Animation - Orbital Bounce */
        @keyframes float-soft {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-12px);
            }
        }
        
        .group-hover\:animate-bounce {
            animation: float-soft 3s cubic-bezier(0.4, 0.0, 0.6, 1.0) infinite;
        }
    </style>
    
    <?php echo $__env->yieldContent('extra-styles'); ?>
</head>
<body class="antialiased text-white">
    <?php echo $__env->yieldContent('content'); ?>
    
    <script>
        (function () {
            const path = window.location.pathname.replace(/\/$/, '');
            if (path === '' || path === '/') {
                const section = document.getElementById('servicios');
                const serviciosLink = document.querySelector('[data-nav="servicios"]');
                const inicioLink = document.querySelector('[data-nav="inicio"]');
                const serviciosUnderline = document.querySelector('.servicios-underline');
                const inicioUnderline = document.querySelector('.inicio-underline');
                
                if (section && serviciosUnderline && inicioUnderline && serviciosLink && inicioLink) {
                    const observer = new IntersectionObserver(
                        (entries) => {
                            entries.forEach((entry) => {
                                if (entry.isIntersecting) {
                                    // Activar Servicios
                                    serviciosUnderline.classList.remove('hidden');
                                    serviciosLink.classList.remove('text-gray-300', 'font-medium');
                                    serviciosLink.classList.add('text-white', 'font-semibold');
                                    
                                    // Desactivar Inicio
                                    inicioUnderline.classList.add('hidden');
                                    inicioLink.classList.remove('text-white', 'font-semibold');
                                    inicioLink.classList.add('text-gray-300', 'font-medium');
                                } else {
                                    // Desactivar Servicios
                                    serviciosUnderline.classList.add('hidden');
                                    serviciosLink.classList.remove('text-white', 'font-semibold');
                                    serviciosLink.classList.add('text-gray-300', 'font-medium');
                                    
                                    // Activar Inicio
                                    inicioUnderline.classList.remove('hidden');
                                    inicioLink.classList.remove('text-gray-300', 'font-medium');
                                    inicioLink.classList.add('text-white', 'font-semibold');
                                }
                            });
                        },
                        { root: null, rootMargin: '-20% 0px -60% 0px', threshold: 0.1 }
                    );
                    observer.observe(section);
                }
            }
        })();
    </script>
    <?php echo $__env->yieldContent('extra-scripts'); ?>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/layouts/landing.blade.php ENDPATH**/ ?>