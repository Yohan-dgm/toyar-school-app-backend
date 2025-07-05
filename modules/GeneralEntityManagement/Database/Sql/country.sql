/*
 Navicat Premium Data Transfer
 
 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 10:15:03
 */
-- ----------------------------
-- Sequence structure for country_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."country_id_seq";

CREATE SEQUENCE "public"."country_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for country
-- ----------------------------
DROP TABLE IF EXISTS "public"."country";

CREATE TABLE "public"."country" (
    "id" int8 NOT NULL DEFAULT nextval('country_id_seq' :: regclass),
    "short_code" varchar(255) COLLATE "pg_catalog"."default",
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "calling_code" varchar(255) COLLATE "pg_catalog"."default",
    "cctld" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO
    "public"."country"
VALUES
    (
        1,
        'AF',
        'Afghanistan',
        '93',
        '.af',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        2,
        'AX',
        'Aland Islands',
        '358',
        '.ax',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        3,
        'AL',
        'Albania',
        '355',
        '.al',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        4,
        'DZ',
        'Algeria',
        '213',
        '.dz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        5,
        'AS',
        'American Samoa',
        '1+684',
        '.as',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        6,
        'AD',
        'Andorra',
        '376',
        '.ad',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        7,
        'AO',
        'Angola',
        '244',
        '.ao',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        8,
        'AI',
        'Anguilla',
        '1+264',
        '.ai',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        9,
        'AQ',
        'Antarctica',
        '672',
        '.aq',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        10,
        'AG',
        'Antigua and Barbuda',
        '1+268',
        '.ag',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        11,
        'AR',
        'Argentina',
        '54',
        '.ar',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        12,
        'AM',
        'Armenia',
        '374',
        '.am',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        13,
        'AW',
        'Aruba',
        '297',
        '.aw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        14,
        'AU',
        'Australia',
        '61',
        '.au',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        15,
        'AT',
        'Austria',
        '43',
        '.at',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        16,
        'AZ',
        'Azerbaijan',
        '994',
        '.az',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        17,
        'BS',
        'Bahamas',
        '1+242',
        '.bs',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        18,
        'BH',
        'Bahrain',
        '973',
        '.bh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        19,
        'BD',
        'Bangladesh',
        '880',
        '.bd',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        20,
        'BB',
        'Barbados',
        '1+246',
        '.bb',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        21,
        'BY',
        'Belarus',
        '375',
        '.by',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        22,
        'BE',
        'Belgium',
        '32',
        '.be',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        23,
        'BZ',
        'Belize',
        '501',
        '.bz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        24,
        'BJ',
        'Benin',
        '229',
        '.bj',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        25,
        'BM',
        'Bermuda',
        '1+441',
        '.bm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        26,
        'BT',
        'Bhutan',
        '975',
        '.bt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        27,
        'BO',
        'Bolivia',
        '591',
        '.bo',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        28,
        'BQ',
        'Bonaire, Sint Eustatius and Saba',
        '599',
        '.bq',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        29,
        'BA',
        'Bosnia and Herzegovina',
        '387',
        '.ba',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        30,
        'BW',
        'Botswana',
        '267',
        '.bw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        31,
        'BV',
        'Bouvet Island',
        'NONE',
        '.bv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        32,
        'BR',
        'Brazil',
        '55',
        '.br',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        33,
        'IO',
        'British Indian Ocean Territory',
        '246',
        '.io',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        34,
        'BN',
        'Brunei',
        '673',
        '.bn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        35,
        'BG',
        'Bulgaria',
        '359',
        '.bg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        36,
        'BF',
        'Burkina Faso',
        '226',
        '.bf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        37,
        'BI',
        'Burundi',
        '257',
        '.bi',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        38,
        'KH',
        'Cambodia',
        '855',
        '.kh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        39,
        'CM',
        'Cameroon',
        '237',
        '.cm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        40,
        'CA',
        'Canada',
        '1',
        '.ca',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        41,
        'CV',
        'Cape Verde',
        '238',
        '.cv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        42,
        'KY',
        'Cayman Islands',
        '1+345',
        '.ky',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        43,
        'CF',
        'Central African Republic',
        '236',
        '.cf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        44,
        'TD',
        'Chad',
        '235',
        '.td',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        45,
        'CL',
        'Chile',
        '56',
        '.cl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        46,
        'CN',
        'China',
        '86',
        '.cn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        47,
        'CX',
        'Christmas Island',
        '61',
        '.cx',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        48,
        'CC',
        'Cocos (Keeling) Islands',
        '61',
        '.cc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        49,
        'CO',
        'Colombia',
        '57',
        '.co',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        50,
        'KM',
        'Comoros',
        '269',
        '.km',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        51,
        'CG',
        'Congo',
        '242',
        '.cg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        52,
        'CK',
        'Cook Islands',
        '682',
        '.ck',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        53,
        'CR',
        'Costa Rica',
        '506',
        '.cr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        54,
        'CI',
        'COTE D IVOIRE',
        '225',
        '.ci',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        55,
        'HR',
        'Croatia',
        '385',
        '.hr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        56,
        'CU',
        'Cuba',
        '53',
        '.cu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        57,
        'CW',
        'Curacao',
        '599',
        '.cw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        58,
        'CY',
        'Cyprus',
        '357',
        '.cy',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        59,
        'CZ',
        'Czech Republic',
        '420',
        '.cz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        60,
        'CD',
        'Democratic Republic of the Congo',
        '243',
        '.cd',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        61,
        'DK',
        'Denmark',
        '45',
        '.dk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        62,
        'DJ',
        'Djibouti',
        '253',
        '.dj',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        63,
        'DM',
        'Dominica',
        '1+767',
        '.dm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        64,
        'DO',
        'Dominican Republic',
        '1+809, 8',
        '.do',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        65,
        'EC',
        'Ecuador',
        '593',
        '.ec',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        66,
        'EG',
        'Egypt',
        '20',
        '.eg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        67,
        'SV',
        'El Salvador',
        '503',
        '.sv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        68,
        'GQ',
        'Equatorial Guinea',
        '240',
        '.gq',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        69,
        'ER',
        'Eritrea',
        '291',
        '.er',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        70,
        'EE',
        'Estonia',
        '372',
        '.ee',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        71,
        'ET',
        'Ethiopia',
        '251',
        '.et',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        72,
        'FK',
        'Falkland Islands (Malvinas)',
        '500',
        '.fk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        73,
        'FO',
        'Faroe Islands',
        '298',
        '.fo',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        74,
        'FJ',
        'Fiji',
        '679',
        '.fj',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        75,
        'FI',
        'Finland',
        '358',
        '.fi',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        76,
        'FR',
        'France',
        '33',
        '.fr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        77,
        'GF',
        'French Guiana',
        '594',
        '.gf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        78,
        'PF',
        'French Polynesia',
        '689',
        '.pf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        79,
        'TF',
        'French Southern Territories',
        NULL,
        '.tf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        80,
        'GA',
        'Gabon',
        '241',
        '.ga',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        81,
        'GM',
        'Gambia',
        '220',
        '.gm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        82,
        'GE',
        'Georgia',
        '995',
        '.ge',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        83,
        'DE',
        'Germany',
        '49',
        '.de',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        84,
        'GH',
        'Ghana',
        '233',
        '.gh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        85,
        'GI',
        'Gibraltar',
        '350',
        '.gi',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        86,
        'GR',
        'Greece',
        '30',
        '.gr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        87,
        'GL',
        'Greenland',
        '299',
        '.gl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        88,
        'GD',
        'Grenada',
        '1+473',
        '.gd',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        89,
        'GP',
        'Guadaloupe',
        '590',
        '.gp',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        90,
        'GU',
        'Guam',
        '1+671',
        '.gu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        91,
        'GT',
        'Guatemala',
        '502',
        '.gt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        92,
        'GG',
        'Guernsey',
        '44',
        '.gg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        93,
        'GN',
        'Guinea',
        '224',
        '.gn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        94,
        'GW',
        'Guinea-Bissau',
        '245',
        '.gw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        95,
        'GY',
        'Guyana',
        '592',
        '.gy',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        96,
        'HT',
        'Haiti',
        '509',
        '.ht',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        97,
        'HM',
        'Heard Island and McDonald Islands',
        'NONE',
        '.hm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        98,
        'HN',
        'Honduras',
        '504',
        '.hn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        99,
        'HK',
        'Hong Kong',
        '852',
        '.hk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        100,
        'HU',
        'Hungary',
        '36',
        '.hu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        101,
        'IS',
        'Iceland',
        '354',
        '.is',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        102,
        'IN',
        'India',
        '91',
        '.in',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        103,
        'ID',
        'Indonesia',
        '62',
        '.id',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        104,
        'IR',
        'Iran',
        '98',
        '.ir',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        105,
        'IQ',
        'Iraq',
        '964',
        '.iq',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        106,
        'IE',
        'Ireland',
        '353',
        '.ie',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        107,
        'IM',
        'Isle of Man',
        '44',
        '.im',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        108,
        'IL',
        'Israel',
        '972',
        '.il',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        109,
        'IT',
        'Italy',
        '39',
        '.jm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        110,
        'JM',
        'Jamaica',
        '1+876',
        '.jm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        111,
        'JP',
        'Japan',
        '81',
        '.jp',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        112,
        'JE',
        'Jersey',
        '44',
        '.je',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        113,
        'JO',
        'Jordan',
        '962',
        '.jo',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        114,
        'KZ',
        'Kazakhstan',
        '7',
        '.kz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        115,
        'KE',
        'Kenya',
        '254',
        '.ke',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        116,
        'KI',
        'Kiribati',
        '686',
        '.ki',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        117,
        'XK',
        'Kosovo',
        '381',
        Null,
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        118,
        'KW',
        'Kuwait',
        '965',
        '.kw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        119,
        'KG',
        'Kyrgyzstan',
        '996',
        '.kg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        120,
        'LA',
        'Laos',
        '856',
        '.la',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        121,
        'LV',
        'Latvia',
        '371',
        '.lv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        122,
        'LB',
        'Lebanon',
        '961',
        '.lb',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        123,
        'LS',
        'Lesotho',
        '266',
        '.ls',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        124,
        'LR',
        'Liberia',
        '231',
        '.lr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        125,
        'LY',
        'Libya',
        '218',
        '.ly',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        126,
        'LI',
        'Liechtenstein',
        '423',
        '.li',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        127,
        'LT',
        'Lithuania',
        '370',
        '.lt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        128,
        'LU',
        'Luxembourg',
        '352',
        '.lu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        129,
        'MO',
        'Macao',
        '853',
        '.mo',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        130,
        'MK',
        'North Macedonia',
        '389',
        '.mk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        131,
        'MG',
        'Madagascar',
        '261',
        '.mg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        132,
        'MW',
        'Malawi',
        '265',
        '.mw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        133,
        'MY',
        'Malaysia',
        '60',
        '.my',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        134,
        'MV',
        'Maldives',
        '960',
        '.mv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        135,
        'ML',
        'Mali',
        '223',
        '.ml',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        136,
        'MT',
        'Malta',
        '356',
        '.mt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        137,
        'MH',
        'Marshall Islands',
        '692',
        '.mh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        138,
        'MQ',
        'Martinique',
        '596',
        '.mq',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        139,
        'MR',
        'Mauritania',
        '222',
        '.mr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        140,
        'MU',
        'Mauritius',
        '230',
        '.mu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        141,
        'YT',
        'Mayotte',
        '262',
        '.yt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        142,
        'MX',
        'Mexico',
        '52',
        '.mx',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        143,
        'FM',
        'Micronesia',
        '691',
        '.fm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        144,
        'MD',
        'Moldava',
        '373',
        '.md',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        145,
        'MC',
        'Monaco',
        '377',
        '.mc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        146,
        'MN',
        'Mongolia',
        '976',
        '.mn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        147,
        'ME',
        'Montenegro',
        '382',
        '.me',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        148,
        'MS',
        'Montserrat',
        '1+664',
        '.ms',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        149,
        'MA',
        'Morocco',
        '212',
        '.ma',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        150,
        'MZ',
        'Mozambique',
        '258',
        '.mz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        151,
        'MM',
        'Myanmar (Burma)',
        '95',
        '.mm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        152,
        'NA',
        'Namibia',
        '264',
        '.na',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        153,
        'NR',
        'Nauru',
        '674',
        '.nr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        154,
        'NP',
        'Nepal',
        '977',
        '.np',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        155,
        'NL',
        'Netherlan    ds',
        '31',
        '.nl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        156,
        'NC',
        'New Caledonia',
        '687',
        '.nc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        157,
        'NZ',
        'New Zealand',
        '64',
        '.nz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        158,
        'NI',
        'Nicaragua',
        '505',
        '.ni',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        159,
        'NE',
        'Niger',
        '227',
        '.ne',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        160,
        'NG',
        'Nigeria',
        '234',
        '.ng',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        161,
        'NU',
        'Niue',
        '683',
        '.nu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        162,
        'NF',
        'Norfolk Island',
        '672',
        '.nf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        163,
        'KP',
        'North Korea',
        '850',
        '.kp',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        164,
        'MP',
        'Northern Mariana Islands',
        '1+670',
        '.mp',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        165,
        'NO',
        'Norway',
        '47',
        '.no',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        166,
        'OM',
        'Oman',
        '968',
        '.om',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        167,
        'PK',
        'Pakistan',
        '92',
        '.pk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        168,
        'PW',
        'Palau',
        '680',
        '.pw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        169,
        'PS',
        'Palestine',
        '970',
        '.ps',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        170,
        'PA',
        'Panama',
        '507',
        '.pa',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        171,
        'PG',
        'Papua New Guinea',
        '675',
        '.pg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        172,
        'PY',
        'Paraguay',
        '595',
        '.py',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        173,
        'PE',
        'Peru',
        '51',
        '.pe',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        174,
        'PH',
        'Philippines',
        '63',
        '.ph',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        175,
        'PN',
        'Pitcairn',
        'NONE',
        '.pn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        176,
        'PL',
        'Poland',
        '48',
        '.pl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        177,
        'PT',
        'Portugal',
        '351',
        '.pt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        178,
        'PR',
        'Puerto Rico',
        '1+939',
        '.pr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        179,
        'QA',
        'Qatar',
        '974',
        '.qa',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        180,
        'RE',
        'Reunion',
        '262',
        '.re',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        181,
        'RO',
        'Romania',
        '40',
        '.ro',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        182,
        'RU',
        'Russia',
        '7',
        '.ru',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        183,
        'RW',
        'Rwanda',
        '250',
        '.rw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        184,
        'BL',
        'Saint Barthelemy',
        '590',
        '.bl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        185,
        'SH',
        'Saint Helena',
        '290',
        '.sh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        186,
        'KN',
        'Saint Kitts and Nevis',
        '1+869',
        '.kn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        187,
        'LC',
        'Saint Lucia',
        '1+758',
        '.lc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        188,
        'MF',
        'Saint Martin',
        '590',
        '.mf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        189,
        'PM',
        'Saint Pierre and Miquelon',
        '508',
        '.pm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        190,
        'VC',
        'Saint Vincent and the Grenadines',
        '1+784',
        '.vc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        191,
        'WS',
        'Samoa',
        '685',
        '.ws',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        192,
        'SM',
        'San Marino',
        '378',
        '.sm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        193,
        'ST',
        'Sao Tome and Principe',
        '239',
        '.st',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        194,
        'SA',
        'Saudi Arabia',
        '966',
        '.sa',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        195,
        'SN',
        'Senegal',
        '221',
        '.sn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        196,
        'RS',
        'Serbia',
        '381',
        '.rs',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        197,
        'SC',
        'Seychelles',
        '248',
        '.sc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        198,
        'SL',
        'Sierra Leone',
        '232',
        '.sl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        199,
        'SG',
        'Singapore',
        '65',
        '.sg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        200,
        'SX',
        'Sint Maarten',
        '1+721',
        '.sx',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        201,
        'SK',
        'Slovakia',
        '421',
        '.sk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        202,
        'SI',
        'Slovenia',
        '386',
        '.si',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        203,
        'SB',
        'Solomon Islands',
        '677',
        '.sb',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        204,
        'SO',
        'Somalia',
        '252',
        '.so',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        205,
        'ZA',
        'South Africa',
        '27',
        '.za',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        206,
        'GS',
        'South Georgia and the South Sandwich Islands',
        '500',
        '.gs',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        207,
        'KR',
        'South Korea',
        '82',
        '.kr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        208,
        'SS',
        'South Sudan',
        '211',
        '.ss',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        209,
        'ES',
        'Spain',
        '34',
        '.es',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        210,
        'LK',
        'Sri Lanka',
        '94',
        '.lk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        211,
        'SD',
        'Sudan',
        '249',
        '.sd',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        212,
        'SR',
        'Suriname',
        '597',
        '.sr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        213,
        'SJ',
        'Svalbard and Jan Mayen',
        '47',
        '.sj',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        214,
        'SZ',
        'Swaziland',
        '268',
        '.sz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        215,
        'SE',
        'Sweden',
        '46',
        '.se',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        216,
        'CH',
        'Switzerland',
        '41',
        '.ch',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        217,
        'SY',
        'Syria',
        '963',
        '.sy',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        218,
        'TW',
        'Taiwan',
        '886',
        '.tw',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        219,
        'TJ',
        'Tajikistan',
        '992',
        '.tj',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        220,
        'TZ',
        'Tanzania',
        '255',
        '.tz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        221,
        'TH',
        'Thailand',
        '66',
        '.th',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        222,
        'TL',
        'Timor-Leste (East Timor)',
        '670',
        '.tl',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        223,
        'TG',
        'Togo',
        '228',
        '.tg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        224,
        'TK',
        'Tokelau',
        '690',
        '.tk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        225,
        'TO',
        'Tonga',
        '676',
        '.to',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        226,
        'TT',
        'Trinidad and Tobago',
        '1+868',
        '.tt',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        227,
        'TN',
        'Tunisia',
        '216',
        '.tn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        228,
        'TR',
        'Turkey',
        '90',
        '.tr',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        229,
        'TM',
        'Turkmenistan',
        '993',
        '.tm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        230,
        'TC',
        'Turks and Caicos Islands',
        '1+649',
        '.tc',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        231,
        'TV',
        'Tuvalu',
        '688',
        '.tv',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        232,
        'UG',
        'Uganda',
        '256',
        '.ug',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        233,
        'UA',
        'Ukraine',
        '380',
        '.ua',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        234,
        'AE',
        'United Arab Emirates',
        '971',
        '.ae',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        235,
        'GB',
        'United Kingdom',
        '44',
        '.uk',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        236,
        'US',
        'United States',
        '1',
        '.us',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        237,
        'UM',
        'United States Minor Outlying Islands',
        'NONE',
        'NONE',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        238,
        'UY',
        'Uruguay',
        '598',
        '.uy',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        239,
        'UZ',
        'Uzbekistan',
        '998',
        '.uz',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        240,
        'VU',
        'Vanuatu',
        '678',
        '.vu',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        241,
        'VA',
        'Vatican City',
        '39',
        '.va',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        242,
        'VE',
        'Venezuela',
        '58',
        '.ve',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        243,
        'VN',
        'Vietnam',
        '84',
        '.vn',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        244,
        'VG',
        'Virgin Islands, British',
        '1+284',
        '.vg',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        245,
        'VI',
        'Virgin Islands, US',
        '1+340',
        '.vi',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        246,
        'WF',
        'Wallis and Futuna',
        '681',
        '.wf',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        247,
        'EH',
        'Western Sahara',
        '212',
        '.eh',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        248,
        'YE',
        'Yemen',
        '967',
        '.ye',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        249,
        'ZM',
        'Zambia',
        '260',
        '.zm',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."country"
VALUES
    (
        250,
        'ZW',
        'Zimbabwe',
        '263',
        '.zw',
        NULL,
        NULL,
        NULL,
        NULL
    );

-- ----------------------------
-- Primary Key structure for table country
-- ----------------------------
ALTER TABLE
    "public"."country"
ADD
    CONSTRAINT "country_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."country_id_seq" OWNED BY "public"."country"."id";

SELECT
    setval('"public"."country_id_seq"', 250, true);