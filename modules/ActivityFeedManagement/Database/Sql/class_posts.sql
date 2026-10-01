/*
 Class Posts Table - Class-specific announcements and posts
 
 Date: 09/10/2025
*/

-- ----------------------------
-- Sequence structure for class_posts_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."class_posts_id_seq";

CREATE SEQUENCE "public"."class_posts_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for class_posts
-- ----------------------------
DROP TABLE IF EXISTS "public"."class_posts";

CREATE TABLE "public"."class_posts" (
    "id" int8 NOT NULL DEFAULT nextval('class_posts_id_seq'::regclass),
    "type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'announcement',
    "category" varchar(100) COLLATE "pg_catalog"."default",
    "title" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "content" text COLLATE "pg_catalog"."default" NOT NULL,
    "author_id" int8 NOT NULL,
    "school_id" int8 NOT NULL,
    "class_id" int8 NOT NULL,
    "grade_level_class_id" int8,
    "likes_count" int4 NOT NULL DEFAULT 0,
    "comments_count" int4 NOT NULL DEFAULT 0,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table class_posts
-- ----------------------------
ALTER TABLE "public"."class_posts" 
ADD CONSTRAINT "class_posts_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for table class_posts
-- ----------------------------
CREATE INDEX "idx_class_posts_school_id" ON "public"."class_posts" USING btree ("school_id");
CREATE INDEX "idx_class_posts_class_id" ON "public"."class_posts" USING btree ("class_id");
CREATE INDEX "idx_class_posts_grade_level_class_id" ON "public"."class_posts" USING btree ("grade_level_class_id");
CREATE INDEX "idx_class_posts_author_id" ON "public"."class_posts" USING btree ("author_id");
CREATE INDEX "idx_class_posts_type" ON "public"."class_posts" USING btree ("type");
CREATE INDEX "idx_class_posts_created_at" ON "public"."class_posts" USING btree ("created_at" DESC);
CREATE INDEX "idx_class_posts_is_active" ON "public"."class_posts" USING btree ("is_active");

-- ----------------------------
-- Set sequence current value
-- ----------------------------
SELECT setval('"public"."class_posts_id_seq"', 1, false);