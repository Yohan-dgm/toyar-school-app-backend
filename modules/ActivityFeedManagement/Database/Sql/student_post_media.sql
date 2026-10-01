/*
 Student Post Media Table - Dedicated media table for student posts
 
 Date: 11/09/2025
*/

-- ----------------------------
-- Sequence structure for student_post_media_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_post_media_id_seq";

CREATE SEQUENCE "public"."student_post_media_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for student_post_media
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_post_media";

CREATE TABLE "public"."student_post_media" (
    "id" int8 NOT NULL DEFAULT nextval('student_post_media_id_seq'::regclass),
    "post_id" int8 NOT NULL,
    "type" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'image',
    "url" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "thumbnail_url" varchar(500) COLLATE "pg_catalog"."default",
    "filename" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "original_filename" varchar(255) COLLATE "pg_catalog"."default",
    "size" int8 NOT NULL DEFAULT 0,
    "mime_type" varchar(100) COLLATE "pg_catalog"."default",
    "width" int4,
    "height" int4,
    "duration" numeric(10,2),
    "sort_order" int4 NOT NULL DEFAULT 0,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table student_post_media
-- ----------------------------
ALTER TABLE "public"."student_post_media" 
ADD CONSTRAINT "student_post_media_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_post_media_id_seq" 
OWNED BY "public"."student_post_media"."id";

SELECT setval('"public"."student_post_media_id_seq"', 1, false);

-- ----------------------------
-- Indexes for table student_post_media
-- ----------------------------
CREATE INDEX "idx_student_post_media_post_id" ON "public"."student_post_media" USING btree ("post_id");
CREATE INDEX "idx_student_post_media_type" ON "public"."student_post_media" USING btree ("type");
CREATE INDEX "idx_student_post_media_sort_order" ON "public"."student_post_media" USING btree ("sort_order");
CREATE INDEX "idx_student_post_media_is_active" ON "public"."student_post_media" USING btree ("is_active");