-- Crear tabla agencias
CREATE TABLE IF NOT EXISTS `agencias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NULL,
  `telefono` varchar(50) NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar columna agencia_id a users
ALTER TABLE `users` ADD COLUMN `agencia_id` bigint unsigned NULL AFTER `google_id`;
ALTER TABLE `users` ADD CONSTRAINT `users_agencia_id_foreign` FOREIGN KEY (`agencia_id`) REFERENCES `agencias` (`id`) ON DELETE SET NULL;
