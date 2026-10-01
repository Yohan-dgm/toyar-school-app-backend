/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 18/08/2025 15:30:00
 */

-- ----------------------------
-- Sequence structure for user_payments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_payments_id_seq";

CREATE SEQUENCE "public"."user_payments_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for user_payments
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_payments";

CREATE TABLE "public"."user_payments" (
    "id" int8 NOT NULL DEFAULT nextval('user_payments_id_seq' :: regclass),
    "user_id" int8 NOT NULL,
    "package_type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
    "is_active" bool NOT NULL DEFAULT true,
    "start_date" date NOT NULL,
    "end_date" date,
    "amount" decimal(10,2),
    "currency" varchar(10) COLLATE "pg_catalog"."default" DEFAULT 'LKR',
    "payment_method" varchar(50) COLLATE "pg_catalog"."default",
    "transaction_reference" varchar(255) COLLATE "pg_catalog"."default",
    "notes" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of user_payments
-- ----------------------------
-- Sample data for testing
INSERT INTO "public"."user_payments" VALUES (1, 38, 'family', true, '2024-08-01', '2025-08-01', 25000.00, 'LKR', 'bank_transfer', 'TXN-20240801-001', 'Annual family package payment', 1, NULL, '2024-08-01 10:00:00', '2024-08-01 10:00:00');
INSERT INTO "public"."user_payments" VALUES (2, 39, 'basic', true, '2024-08-01', '2025-08-01', 15000.00, 'LKR', 'online', 'TXN-20240801-002', 'Basic package for single student', 1, NULL, '2024-08-01 11:00:00', '2024-08-01 11:00:00');

-- ----------------------------
-- Primary Key structure for table user_payments
-- ----------------------------
ALTER TABLE "public"."user_payments" ADD CONSTRAINT "user_payments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table user_payments
-- ----------------------------
ALTER TABLE "public"."user_payments" ADD CONSTRAINT "fk_user_payments_user_id" FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."user_payments" ADD CONSTRAINT "fk_user_payments_created_by" FOREIGN KEY ("created_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE "public"."user_payments" ADD CONSTRAINT "fk_user_payments_updated_by" FOREIGN KEY ("updated_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;

-- ----------------------------
-- Indexes for performance
-- ----------------------------
CREATE INDEX "idx_user_payments_user_id" ON "public"."user_payments" USING btree ("user_id");
CREATE INDEX "idx_user_payments_is_active" ON "public"."user_payments" USING btree ("is_active");
CREATE INDEX "idx_user_payments_package_type" ON "public"."user_payments" USING btree ("package_type");
CREATE INDEX "idx_user_payments_start_date" ON "public"."user_payments" USING btree ("start_date");
CREATE INDEX "idx_user_payments_end_date" ON "public"."user_payments" USING btree ("end_date");

-- ----------------------------
-- Check constraints for package types
-- ----------------------------
ALTER TABLE "public"."user_payments" ADD CONSTRAINT "chk_package_type" CHECK (package_type IN ('basic', 'family', 'premium', 'annual'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_payments_id_seq" OWNED BY "public"."user_payments"."id";

SELECT setval('"public"."user_payments_id_seq"', 2, true);