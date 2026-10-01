/*
 Class Post Hashtags Table - Dedicated hashtags table for class posts
 
 Date: 11/09/2025
*/

-- ----------------------------
-- Sequence structure for class_post_hashtags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."class_post_hashtags_id_seq";

CREATE SEQUENCE "public"."class_post_hashtags_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for class_post_hashtags
-- ----------------------------
DROP TABLE IF EXISTS "public"."class_post_hashtags";

CREATE TABLE "public"."class_post_hashtags" (
    "id" int8 NOT NULL DEFAULT nextval('class_post_hashtags_id_seq'::regclass),
    "hashtag" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "post_id" int8 NOT NULL,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table class_post_hashtags
-- ----------------------------
ALTER TABLE "public"."class_post_hashtags" 
ADD CONSTRAINT "class_post_hashtags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."class_post_hashtags_id_seq" 
OWNED BY "public"."class_post_hashtags"."id";

SELECT setval('"public"."class_post_hashtags_id_seq"', 1, false);

-- ----------------------------
-- Indexes for table class_post_hashtags
-- ----------------------------
CREATE INDEX "idx_class_post_hashtags_post_id" ON "public"."class_post_hashtags" USING btree ("post_id");
CREATE INDEX "idx_class_post_hashtags_hashtag" ON "public"."class_post_hashtags" USING btree ("hashtag");
CREATE INDEX "idx_class_post_hashtags_is_active" ON "public"."class_post_hashtags" USING btree ("is_active");