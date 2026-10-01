/*
 User Push Tokens Table - Store Expo push notification tokens
 
 This table manages push notification tokens for mobile devices.
 Each user can have multiple devices, and each device has a unique token.
*/

-- ----------------------------
-- Sequence structure for user_push_tokens_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_push_tokens_id_seq";

CREATE SEQUENCE "public"."user_push_tokens_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for user_push_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_push_tokens";

CREATE TABLE "public"."user_push_tokens" (
    "id" int8 NOT NULL DEFAULT nextval('user_push_tokens_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "device_id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "push_token" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "platform" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
    "app_version" varchar(50) COLLATE "pg_catalog"."default",
    "device_name" varchar(255) COLLATE "pg_catalog"."default",
    "device_model" varchar(255) COLLATE "pg_catalog"."default",
    "os_version" varchar(50) COLLATE "pg_catalog"."default",
    "is_active" bool DEFAULT true,
    "last_used_at" timestamp(0) DEFAULT now(),
    "failed_deliveries" int4 DEFAULT 0,
    "last_failure_at" timestamp(0),
    "failure_reason" text COLLATE "pg_catalog"."default",
    "created_at" timestamp(0) DEFAULT now(),
    "updated_at" timestamp(0) DEFAULT now()
);

-- ----------------------------
-- Primary Key structure for table user_push_tokens
-- ----------------------------
ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Unique constraints
-- ----------------------------
ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_push_token_unique" 
UNIQUE ("push_token");

ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_user_device_unique" 
UNIQUE ("user_id", "device_id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_platform_check" 
CHECK (platform IN ('ios', 'android'));

ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_failed_deliveries_check" 
CHECK (failed_deliveries >= 0);

-- ----------------------------
-- Indexes for table user_push_tokens
-- ----------------------------
CREATE INDEX "idx_user_push_tokens_user_id" ON "public"."user_push_tokens" USING btree ("user_id");
CREATE INDEX "idx_user_push_tokens_is_active" ON "public"."user_push_tokens" USING btree ("is_active");
CREATE INDEX "idx_user_push_tokens_last_used_at" ON "public"."user_push_tokens" USING btree ("last_used_at" DESC);
CREATE INDEX "idx_user_push_tokens_failed_deliveries" ON "public"."user_push_tokens" USING btree ("failed_deliveries") WHERE failed_deliveries > 0;
CREATE INDEX "idx_user_push_tokens_platform" ON "public"."user_push_tokens" USING btree ("platform");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_push_tokens_id_seq" 
OWNED BY "public"."user_push_tokens"."id";

SELECT setval('"public"."user_push_tokens_id_seq"', 1, false);

-- ----------------------------
-- Foreign Keys
-- ----------------------------
ALTER TABLE "public"."user_push_tokens" 
ADD CONSTRAINT "user_push_tokens_user_id_foreign" 
FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE ON UPDATE CASCADE;