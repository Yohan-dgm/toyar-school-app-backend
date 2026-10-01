/*
 School Post Hashtags Table - Dedicated hashtags table for school posts
 
 Date: 11/09/2025
*/

-- ----------------------------
-- Sequence structure for school_post_hashtags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_post_hashtags_id_seq";

CREATE SEQUENCE "public"."school_post_hashtags_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for school_post_hashtags
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_post_hashtags";

CREATE TABLE "public"."school_post_hashtags" (
    "id" int8 NOT NULL DEFAULT nextval('school_post_hashtags_id_seq'::regclass),
    "hashtag" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "post_id" int8 NOT NULL,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table school_post_hashtags
-- ----------------------------
ALTER TABLE "public"."school_post_hashtags" 
ADD CONSTRAINT "school_post_hashtags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_post_hashtags_id_seq" 
OWNED BY "public"."school_post_hashtags"."id";

SELECT setval('"public"."school_post_hashtags_id_seq"', 1, false);

-- ----------------------------
-- Indexes for table school_post_hashtags
-- ----------------------------
CREATE INDEX "idx_school_post_hashtags_post_id" ON "public"."school_post_hashtags" USING btree ("post_id");
CREATE INDEX "idx_school_post_hashtags_hashtag" ON "public"."school_post_hashtags" USING btree ("hashtag");
CREATE INDEX "idx_school_post_hashtags_is_active" ON "public"."school_post_hashtags" USING btree ("is_active");