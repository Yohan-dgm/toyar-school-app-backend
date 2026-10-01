/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_backend_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 11/08/2025 17:30:00
*/

-- ----------------------------
-- Sequence structure for announcement_categories_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."announcement_categories_id_seq";

CREATE SEQUENCE "public"."announcement_categories_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for announcement_categories
-- ----------------------------
DROP TABLE IF EXISTS "public"."announcement_categories";

CREATE TABLE "public"."announcement_categories" (
    "id" int8 NOT NULL DEFAULT nextval('announcement_categories_id_seq'::regclass),
    "name" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "slug" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "description" text COLLATE "pg_catalog"."default",
    "color" varchar(20) COLLATE "pg_catalog"."default" DEFAULT '#3b82f6',
    "icon" varchar(50) COLLATE "pg_catalog"."default" DEFAULT 'megaphone',
    "sort_order" int4 DEFAULT 0,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of announcement_categories
-- ----------------------------
INSERT INTO "public"."announcement_categories" VALUES
    (1, 'General', 'general', 'General school announcements and notices', '#3b82f6', 'megaphone', 1, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (2, 'Academic', 'academic', 'Academic-related announcements including exams, assignments, and curriculum updates', '#10b981', 'book-open', 2, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (3, 'Events', 'events', 'School events, activities, and special programs', '#f59e0b', 'calendar', 3, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (4, 'Emergency', 'emergency', 'Emergency notices and urgent communications', '#ef4444', 'exclamation-triangle', 4, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (5, 'Administrative', 'administrative', 'Administrative updates, policy changes, and official notices', '#8b5cf6', 'clipboard-list', 5, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (6, 'Sports', 'sports', 'Sports activities, competitions, and athletic events', '#06b6d4', 'trophy', 6, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (7, 'Health & Safety', 'health-safety', 'Health guidelines, safety protocols, and wellness information', '#84cc16', 'shield-check', 7, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00'),
    (8, 'Admissions', 'admissions', 'Admission procedures, deadlines, and enrollment information', '#ec4899', 'user-plus', 8, 't', 1, NULL, '2025-08-11 17:00:00', '2025-08-11 17:00:00');

-- ----------------------------
-- Primary Key structure for table announcement_categories
-- ----------------------------
ALTER TABLE "public"."announcement_categories" 
ADD CONSTRAINT "announcement_categories_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraint for slug
-- ----------------------------
ALTER TABLE "public"."announcement_categories" 
ADD CONSTRAINT "announcement_categories_slug_unique" UNIQUE ("slug");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."announcement_categories_id_seq" 
OWNED BY "public"."announcement_categories"."id";

SELECT setval('"public"."announcement_categories_id_seq"', 8, true);

-- ----------------------------
-- Indexes for table announcement_categories
-- ----------------------------
CREATE INDEX "idx_announcement_categories_slug" ON "public"."announcement_categories" USING btree ("slug");
CREATE INDEX "idx_announcement_categories_is_active" ON "public"."announcement_categories" USING btree ("is_active");
CREATE INDEX "idx_announcement_categories_sort_order" ON "public"."announcement_categories" USING btree ("sort_order");