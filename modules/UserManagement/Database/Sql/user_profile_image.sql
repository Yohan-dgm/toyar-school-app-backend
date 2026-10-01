/*
 User Profile Image table for storing user profile photos
 
 Source Server Type    : PostgreSQL
 Target Server Type    : PostgreSQL
 File Encoding         : 65001

 Date: 27/08/2025 00:00:00
*/

-- ----------------------------
-- Sequence structure for user_profile_image_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_profile_image_id_seq";

CREATE SEQUENCE "public"."user_profile_image_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for user_profile_image
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_profile_image";

CREATE TABLE "public"."user_profile_image" (
    "id" int8 NOT NULL DEFAULT nextval('user_profile_image_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "file_path" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "filename" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "file_format" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
    "file_size" int8 NOT NULL DEFAULT 0,
    "mime_type" varchar(100) COLLATE "pg_catalog"."default",
    "width" int4,
    "height" int4,
    "is_active" bool NOT NULL DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Comments on table and columns
-- ----------------------------
COMMENT ON TABLE "public"."user_profile_image" IS 'Stores user profile image information';
COMMENT ON COLUMN "public"."user_profile_image"."user_id" IS 'Foreign key to user table';
COMMENT ON COLUMN "public"."user_profile_image"."file_path" IS 'Full path to the stored image file';
COMMENT ON COLUMN "public"."user_profile_image"."filename" IS 'Original filename of uploaded image';
COMMENT ON COLUMN "public"."user_profile_image"."file_format" IS 'File extension (jpg, png, webp, etc.)';
COMMENT ON COLUMN "public"."user_profile_image"."file_size" IS 'File size in bytes';
COMMENT ON COLUMN "public"."user_profile_image"."mime_type" IS 'MIME type of the image';
COMMENT ON COLUMN "public"."user_profile_image"."width" IS 'Image width in pixels';
COMMENT ON COLUMN "public"."user_profile_image"."height" IS 'Image height in pixels';
COMMENT ON COLUMN "public"."user_profile_image"."is_active" IS 'Whether this is the current active profile image';

-- ----------------------------
-- Primary Key structure for table user_profile_image
-- ----------------------------
ALTER TABLE "public"."user_profile_image" 
ADD CONSTRAINT "user_profile_image_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key constraints
-- ----------------------------
ALTER TABLE "public"."user_profile_image" 
ADD CONSTRAINT "fk_user_profile_image_user_id" 
FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE "public"."user_profile_image" 
ADD CONSTRAINT "fk_user_profile_image_created_by" 
FOREIGN KEY ("created_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE "public"."user_profile_image" 
ADD CONSTRAINT "fk_user_profile_image_updated_by" 
FOREIGN KEY ("updated_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;

-- ----------------------------
-- Indexes for table user_profile_image
-- ----------------------------
CREATE INDEX "idx_user_profile_image_user_id" ON "public"."user_profile_image" USING btree ("user_id");
CREATE INDEX "idx_user_profile_image_is_active" ON "public"."user_profile_image" USING btree ("is_active");
CREATE INDEX "idx_user_profile_image_user_active" ON "public"."user_profile_image" USING btree ("user_id", "is_active");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_profile_image_id_seq" 
OWNED BY "public"."user_profile_image"."id";

SELECT setval('"public"."user_profile_image_id_seq"', 1, false);