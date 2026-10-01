-- ----------------------------
-- Sequence structure for file_uploads_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."file_uploads_id_seq";

CREATE SEQUENCE "public"."file_uploads_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for file_uploads
-- ----------------------------
DROP TABLE IF EXISTS "public"."file_uploads";

CREATE TABLE "public"."file_uploads" (
    "id" int8 NOT NULL DEFAULT nextval('file_uploads_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "filename" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "mime_type" varchar(100) COLLATE "pg_catalog"."default",
    "total_size" int8 NOT NULL,
    "uploaded_size" int8 NOT NULL DEFAULT 0,
    "status" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'pending',
    "storage_path" varchar(500) COLLATE "pg_catalog"."default",
    "metadata" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table file_uploads
-- ----------------------------
ALTER TABLE "public"."file_uploads" 
ADD CONSTRAINT "file_uploads_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."file_uploads" 
ADD CONSTRAINT "file_uploads_status_check" 
CHECK (status IN ('pending', 'uploading', 'completed', 'failed', 'cancelled'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."file_uploads_id_seq" 
OWNED BY "public"."file_uploads"."id";

-- ----------------------------
-- Indexes for table file_uploads
-- ----------------------------
CREATE INDEX "idx_file_uploads_user_id" ON "public"."file_uploads" USING btree ("user_id");
CREATE INDEX "idx_file_uploads_status" ON "public"."file_uploads" USING btree ("status");
CREATE INDEX "idx_file_uploads_created_at" ON "public"."file_uploads" USING btree ("created_at");
