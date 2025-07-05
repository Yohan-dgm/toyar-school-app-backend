{
    "ReportVersion": "2025.1.1",
    "ReportGuid": "ebef8346d08c055269ccca5017478ac9",
    "ReportName": "Receipt Voucher",
    "ReportAlias": "Receipt Voucher",
    "ReportFile": "get-receipt-voucher-data-report.mrt",
    "ReportAuthor": "Solovo Systems",
    "ReportCreated": "/Date(0+0530)/",
    "ReportChanged": "/Date(1739773321000+0530)/",
    "EngineVersion": "EngineV2",
    "ReportUnit": "HundredthsOfInch",
    "Culture": "en-US",
    "PreviewSettings": 25108991,
    "CalculationMode": "Interpretation",
    "Styles": {
        "0": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Placement": "DataEvenStyle",
                    "ComponentName": "Data"
                }
            },
            "Name": "Black Data Even",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:236,240,241",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "1": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "HorizontalLinePrimitive1"
                }
            },
            "Name": "Black Primitive Line",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";White;5;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "2": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "Placement": "PageHeader",
                    "ComponentName": "Text01"
                }
            },
            "Name": "Black Company Name",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red",
            "AllowUseHorAlignment": true
        },
        "3": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text1"
                }
            },
            "Name": "Black Company Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "4": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "Placement": "ReportTitle",
                    "ComponentName": "Text2"
                }
            },
            "Name": "Black Bill To",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:43,43,43",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "5": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text3"
                }
            },
            "Name": "Black Bill To Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "6": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "Placement": "ReportTitle",
                    "ComponentName": "ReportTitleBand1"
                }
            },
            "Name": "Black Requisites",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:43,43,43",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "7": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "Placement": "ReportTitle",
                    "ComponentName": "Text02"
                }
            },
            "Name": "Black Title",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "8": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text5"
                }
            },
            "Name": "Black Data",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "9": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text6"
                }
            },
            "Name": "Black Contact Name",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "10": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text4"
                }
            },
            "Name": "Black subtotals",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:213,218,222",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "11": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text05"
                }
            },
            "Name": "Black Discount",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "12": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text7"
                }
            },
            "Name": "Black Total",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:43,43,43",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "13": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text03"
                }
            },
            "Name": "Black Thanks",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": "Bottom;43,43,43;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "14": {
            "Ident": "StiStyle",
            "CollectionName": "Black",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text04"
                }
            },
            "Name": "Black Notes",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "15": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "Placement": "PageHeader",
                    "Location": "MiddleLeft",
                    "ComponentName": "Text01"
                }
            },
            "Name": "Lime Company Name",
            "HorAlignment": "Center",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "16": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text1"
                }
            },
            "Name": "Lime Company Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "17": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text2"
                }
            },
            "Name": "Lime Bill To",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:145,200,83",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "18": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text3"
                }
            },
            "Name": "Lime Bill To Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "19": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "ReportTitleBand1"
                }
            },
            "Name": "Lime Requisites",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:60,63,70",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "20": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text02"
                }
            },
            "Name": "Lime Title",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:145,200,83",
            "NegativeTextBrush": "solid:Red"
        },
        "21": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text4"
                }
            },
            "Name": "Lime Headers",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:145,200,83",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "22": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text5"
                }
            },
            "Name": "Lime Data",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:120,120,120",
            "NegativeTextBrush": "solid:Red"
        },
        "23": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text6"
                }
            },
            "Name": "Lime Contact Name",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "24": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Placement": "DataEvenStyle",
                    "ComponentName": "Data"
                }
            },
            "Name": "Lime Data Even",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:236,240,241",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "25": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text05"
                }
            },
            "Name": "Lime Discount",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:130,191,62",
            "NegativeTextBrush": "solid:Red"
        },
        "26": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text7"
                }
            },
            "Name": "Lime Total",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:145,200,83",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "27": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text03"
                }
            },
            "Name": "Lime Thanks",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": "Bottom;155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:130,191,62",
            "NegativeTextBrush": "solid:Red"
        },
        "28": {
            "Ident": "StiStyle",
            "CollectionName": "Lime",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text04"
                }
            },
            "Name": "Lime Notes",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "29": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text01"
                }
            },
            "Name": "Aqua Company Name",
            "HorAlignment": "Center",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Gray",
            "NegativeTextBrush": "solid:Red"
        },
        "30": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text1"
                }
            },
            "Name": "Aqua Company Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Gray",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "31": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text2"
                }
            },
            "Name": "Aqua Bill To",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:123,215,238",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "32": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text3"
                }
            },
            "Name": "Aqua Bill To Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Gray",
            "NegativeTextBrush": "solid:Red"
        },
        "33": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "ReportTitleBand1"
                }
            },
            "Name": "Aqua Requisites",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:123,215,238",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "34": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text02"
                }
            },
            "Name": "Aqua Title",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:123,215,238",
            "NegativeTextBrush": "solid:Red"
        },
        "35": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text4"
                }
            },
            "Name": "Aqua Headers",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:123,215,238",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "36": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text5"
                }
            },
            "Name": "Aqua Data",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:120,120,120",
            "NegativeTextBrush": "solid:Red"
        },
        "37": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text6"
                }
            },
            "Name": "Aqua Contact Name",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Gray",
            "NegativeTextBrush": "solid:Red"
        },
        "38": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text05"
                }
            },
            "Name": "Aqua Discount",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:123,215,238",
            "NegativeTextBrush": "solid:Red"
        },
        "39": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text7"
                }
            },
            "Name": "Aqua Total",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:123,215,238",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "40": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Placement": "DataEvenStyle",
                    "ComponentName": "Data"
                }
            },
            "Name": "Aqua Data Even",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:236,240,241",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "41": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text03"
                }
            },
            "Name": "Aqua Thanks",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": "Bottom;155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:123,215,238",
            "NegativeTextBrush": "solid:Red"
        },
        "42": {
            "Ident": "StiStyle",
            "CollectionName": "Aqua",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text04"
                }
            },
            "Name": "Aqua Notes",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:Gray",
            "NegativeTextBrush": "solid:Red"
        },
        "43": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text01"
                }
            },
            "Name": "PeachPuff Company Name",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "44": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text1"
                }
            },
            "Name": "PeachPuff Company Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "45": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text2"
                }
            },
            "Name": "PeachPuff Bill To",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:241,145,94",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "46": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text3"
                }
            },
            "Name": "PeachPuff Bill To Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "47": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "ReportTitleBand1"
                }
            },
            "Name": "PeachPuff Requisites",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:241,145,94",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "48": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text02"
                }
            },
            "Name": "PeachPuff Title",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:241,145,94",
            "NegativeTextBrush": "solid:Red"
        },
        "49": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text4"
                }
            },
            "Name": "PeachPuff Headers",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": "Left;236,240,241;;;;;;solid:Black",
            "Brush": "solid:213,218,222",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "50": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text5"
                }
            },
            "Name": "PeachPuff Data",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";241,145,94;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:120,120,120",
            "NegativeTextBrush": "solid:Red"
        },
        "51": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text6"
                }
            },
            "Name": "PeachPuff Contacts Name",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "52": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text05"
                }
            },
            "Name": "PeachPuff Discount",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:241,145,94",
            "NegativeTextBrush": "solid:Red"
        },
        "53": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text7"
                }
            },
            "Name": "PeachPuff Totals",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:241,145,94",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "54": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Placement": "DataEvenStyle",
                    "ComponentName": "Data"
                }
            },
            "Name": "PeachPuff Data Even",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:236,240,241",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "55": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text03"
                }
            },
            "Name": "PeachPuff Thanks",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": "Bottom;60,63,70;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:241,145,94",
            "NegativeTextBrush": "solid:Red"
        },
        "56": {
            "Ident": "StiStyle",
            "CollectionName": "PeachPuff",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text04"
                }
            },
            "Name": "PeachPuff Notes",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "57": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text01"
                }
            },
            "Name": "Red Company Name",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "58": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text1"
                }
            },
            "Name": "Red Company Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red",
            "AllowUseBorderFormatting": false,
            "AllowUseBorderSides": false
        },
        "59": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text2"
                }
            },
            "Name": "Red Bill To",
            "Font": "Microsoft Sans Serif;14.25;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:238,121,108",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "60": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text3"
                }
            },
            "Name": "Red Bill To Info",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "61": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "ReportTitleBand1"
                }
            },
            "Name": "Red Requisites",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:238,121,108",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "62": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Placement": "DataEvenStyle",
                    "ComponentName": "Data"
                }
            },
            "Name": "Red Data Even",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";43,43,43;;;;;;solid:Black",
            "Brush": "solid:236,240,241",
            "TextBrush": "solid:43,43,43",
            "NegativeTextBrush": "solid:Red"
        },
        "63": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text02"
                }
            },
            "Name": "Red Title",
            "Font": "Microsoft Sans Serif;18;Bold;",
            "Border": ";155,155,155;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:232,76,61",
            "NegativeTextBrush": "solid:Red"
        },
        "64": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text4"
                }
            },
            "Name": "Red Headers",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": "Left;White;;;;;;solid:Black",
            "Brush": "solid:208,213,216",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "65": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text5"
                }
            },
            "Name": "Red Data",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";232,76,61;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:120,120,120",
            "NegativeTextBrush": "solid:Red"
        },
        "66": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text6"
                }
            },
            "Name": "Red Contacts Name",
            "Font": "Microsoft Sans Serif;9.75;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "67": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text05"
                }
            },
            "Name": "Red Discount",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";145,145,145;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:232,76,61",
            "NegativeTextBrush": "solid:Red"
        },
        "68": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "OperationComponentName": "BeginningWith",
                    "ComponentName": "Text7"
                }
            },
            "Name": "Red Totals",
            "Font": "Microsoft Sans Serif;12;Bold;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:232,76,61",
            "TextBrush": "solid:White",
            "NegativeTextBrush": "solid:Red"
        },
        "69": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text03"
                }
            },
            "Name": "Red Thanks",
            "Font": "Microsoft Sans Serif;12;;",
            "Border": "Bottom;60,63,70;;;;;;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:232,76,61",
            "NegativeTextBrush": "solid:Red"
        },
        "70": {
            "Ident": "StiStyle",
            "CollectionName": "Red",
            "Conditions": {
                "0": {
                    "Ident": "StiStyleCondition",
                    "Type": "ComponentName",
                    "ComponentName": "Text04"
                }
            },
            "Name": "Red Notes",
            "Font": "Microsoft Sans Serif;9.75;;",
            "Border": ";155,155,155;;;;;true;solid:Black",
            "Brush": "solid:",
            "TextBrush": "solid:60,63,70",
            "NegativeTextBrush": "solid:Red"
        },
        "71": {
            "Ident": "StiStyle",
            "Description": "Black",
            "Name": "BlackSample",
            "Border": ";;;;;;;solid:Black",
            "Brush": "solid:43,43,43",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "72": {
            "Ident": "StiStyle",
            "Description": "Lime",
            "Name": "LimeSample",
            "Border": ";;;;;;;solid:Black",
            "Brush": "solid:145,200,83",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "73": {
            "Ident": "StiStyle",
            "Description": "Aqua",
            "Name": "AquaSample",
            "Border": ";;;;;;;solid:Black",
            "Brush": "solid:123,215,238",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "74": {
            "Ident": "StiStyle",
            "Description": "Peach Puff",
            "Name": "PeachPuffSample",
            "Border": ";;;;;;;solid:Black",
            "Brush": "solid:241,145,94",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        },
        "75": {
            "Ident": "StiStyle",
            "Description": "Red",
            "Name": "RedSample",
            "Border": ";;;;;;;solid:Black",
            "Brush": "solid:232,76,61",
            "TextBrush": "solid:Black",
            "NegativeTextBrush": "solid:Red"
        }
    },
    "GlobalizationStrings": {
        "0": {
            "CultureName": "en"
        },
        "1": {
            "CultureName": "ru",
            "Items": {
                "0": {
                    "PropertyName": "ReportAlias",
                    "Text": "Заказ"
                },
                "1": {
                    "PropertyName": "ReportDescription",
                    "Text": "Этот пример демонстрирует, как создать Заказ"
                },
                "2": {
                    "PropertyName": "Text22.Text",
                    "Text": "ЭЛЕМЕНТ №"
                },
                "3": {
                    "PropertyName": "Text23.Text",
                    "Text": "ОПИСАНИЕ"
                },
                "4": {
                    "PropertyName": "Text24.Text",
                    "Text": "КОЛ-ВО"
                },
                "5": {
                    "PropertyName": "Text25.Text",
                    "Text": "ЦЕНА"
                },
                "6": {
                    "PropertyName": "Text63.Text",
                    "Text": "Всего НДС"
                }
            }
        },
        "2": {
            "CultureName": "de",
            "Items": {
                "0": {
                    "PropertyName": "ReportAlias",
                    "Text": "Bestellung"
                },
                "1": {
                    "PropertyName": "ReportDescription",
                    "Text": "Das Beispiel zeigt, wie man die Bestellung erstellen kann\n"
                },
                "2": {
                    "PropertyName": "Text119.Tag",
                    "Text": "GESAMTBETRAG"
                },
                "3": {
                    "PropertyName": "Text22.Tag",
                    "Text": "KOPFZEILE"
                },
                "4": {
                    "PropertyName": "Text22.Text",
                    "Text": "ELEMENT#"
                },
                "5": {
                    "PropertyName": "Text23.Tag",
                    "Text": "KOPFZEILE"
                },
                "6": {
                    "PropertyName": "Text23.Text",
                    "Text": "BESCHREIBUNG"
                },
                "7": {
                    "PropertyName": "Text24.Tag",
                    "Text": "KOPFZEILE"
                },
                "8": {
                    "PropertyName": "Text24.Text",
                    "Text": "Quantität"
                },
                "9": {
                    "PropertyName": "Text25.Tag",
                    "Text": "KOPFZEILE"
                },
                "10": {
                    "PropertyName": "Text25.Text",
                    "Text": "STÜCKPREIS"
                },
                "11": {
                    "PropertyName": "Text63.Text",
                    "Text": "Gesamte MwST"
                },
                "12": {
                    "PropertyName": "Variable.BillToAddress",
                    "Text": "87 Polk Str."
                },
                "13": {
                    "PropertyName": "Variable.CompanyName",
                    "Text": "Firmenname"
                },
                "14": {
                    "PropertyName": "Variable.Notes",
                    "Text": "Verwenden Sie obige Information, um die Bestellung per Banküberweisung zu bezahlen. Achten Sie darauf, Ihre Rechnungsnummer anzugeben.\nIhre Bank könnte zusätzliche Gebühren, die Sie akzeptieren müssen, erfordern. \n"
                }
            }
        }
    },
    "Dictionary": {
        "Variables": {
            "0": {
                "Value": "496",
                "Name": "receipt_voucher_id",
                "DialogInfo": {
                    "DateTimeType": "DateAndTime",
                    "SortDirection": "None"
                },
                "Alias": "receipt_voucher_id",
                "Type": "System.Int32",
                "Key": "_x0037_93fc72e64e449ef8ec4f798ed34fb71"
            }
        },
        "DataSources": {
            "0": {
                "Ident": "StiPostgreSQLSource",
                "Name": "bank_account",
                "Alias": "bank_account",
                "Key": "c2cb1d55b0f0438a835a3525dbf781a9",
                "Columns": {
                    "0": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "1": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "name",
                        "NameInSource": "name",
                        "Alias": "name",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "5": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from bank_account"
            },
            "1": {
                "Ident": "StiPostgreSQLSource",
                "Name": "bank",
                "Alias": "bank",
                "Key": "a160ecbd8d3f4e879628460f7ae401cb",
                "Columns": {
                    "0": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "1": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "name",
                        "NameInSource": "name",
                        "Alias": "name",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "5": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from bank"
            },
            "2": {
                "Ident": "StiPostgreSQLSource",
                "Name": "cash_account",
                "Alias": "cash_account",
                "Key": "f359d70cc0184c40802cbee748e6e0ed",
                "Columns": {
                    "0": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "1": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "name",
                        "NameInSource": "name",
                        "Alias": "name",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "5": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from cash_account"
            },
            "3": {
                "Ident": "StiPostgreSQLSource",
                "Name": "receipt_voucher",
                "Alias": "receipt_voucher",
                "Key": "069791e185c74ea186db74195fde66ee",
                "Columns": {
                    "0": {
                        "Name": "applicant_id",
                        "NameInSource": "applicant_id",
                        "Alias": "applicant_id",
                        "Type": "System.Int32"
                    },
                    "1": {
                        "Name": "bank_account_id",
                        "NameInSource": "bank_account_id",
                        "Alias": "bank_account_id",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "bank_deposit_date",
                        "NameInSource": "bank_deposit_date",
                        "Alias": "bank_deposit_date",
                        "Type": "System.DateTime"
                    },
                    "3": {
                        "Name": "cash_account_id",
                        "NameInSource": "cash_account_id",
                        "Alias": "cash_account_id",
                        "Type": "System.Int32"
                    },
                    "4": {
                        "Name": "cash_received_date",
                        "NameInSource": "cash_received_date",
                        "Alias": "cash_received_date",
                        "Type": "System.DateTime"
                    },
                    "5": {
                        "Name": "check_bank_id",
                        "NameInSource": "check_bank_id",
                        "Alias": "check_bank_id",
                        "Type": "System.Int32"
                    },
                    "6": {
                        "Name": "check_date",
                        "NameInSource": "check_date",
                        "Alias": "check_date",
                        "Type": "System.DateTime"
                    },
                    "7": {
                        "Name": "check_number",
                        "NameInSource": "check_number",
                        "Alias": "check_number",
                        "Type": "System.String"
                    },
                    "8": {
                        "Name": "check_received_date",
                        "NameInSource": "check_received_date",
                        "Alias": "check_received_date",
                        "Type": "System.DateTime"
                    },
                    "9": {
                        "Name": "check_type",
                        "NameInSource": "check_type",
                        "Alias": "check_type",
                        "Type": "System.String"
                    },
                    "10": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "11": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "12": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "13": {
                        "Name": "narration",
                        "NameInSource": "narration",
                        "Alias": "narration",
                        "Type": "System.String"
                    },
                    "14": {
                        "Name": "payment_method",
                        "NameInSource": "payment_method",
                        "Alias": "payment_method",
                        "Type": "System.String"
                    },
                    "15": {
                        "Name": "payment_received_by_id",
                        "NameInSource": "payment_received_by_id",
                        "Alias": "payment_received_by_id",
                        "Type": "System.Int32"
                    },
                    "16": {
                        "Name": "payment_received_date",
                        "NameInSource": "payment_received_date",
                        "Alias": "payment_received_date",
                        "Type": "System.DateTime"
                    },
                    "17": {
                        "Name": "receipt_party",
                        "NameInSource": "receipt_party",
                        "Alias": "receipt_party",
                        "Type": "System.String"
                    },
                    "18": {
                        "Name": "receipt_voucher_status_type_id",
                        "NameInSource": "receipt_voucher_status_type_id",
                        "Alias": "receipt_voucher_status_type_id",
                        "Type": "System.Int32"
                    },
                    "19": {
                        "Name": "serial_number",
                        "NameInSource": "serial_number",
                        "Alias": "serial_number",
                        "Type": "System.String"
                    },
                    "20": {
                        "Name": "serial_number_current_year",
                        "NameInSource": "serial_number_current_year",
                        "Alias": "serial_number_current_year",
                        "Type": "System.Int32"
                    },
                    "21": {
                        "Name": "serial_number_digits",
                        "NameInSource": "serial_number_digits",
                        "Alias": "serial_number_digits",
                        "Type": "System.Int32"
                    },
                    "22": {
                        "Name": "serial_number_financial_year",
                        "NameInSource": "serial_number_financial_year",
                        "Alias": "serial_number_financial_year",
                        "Type": "System.String"
                    },
                    "23": {
                        "Name": "serial_number_prefix",
                        "NameInSource": "serial_number_prefix",
                        "Alias": "serial_number_prefix",
                        "Type": "System.String"
                    },
                    "24": {
                        "Name": "serial_number_suffix",
                        "NameInSource": "serial_number_suffix",
                        "Alias": "serial_number_suffix",
                        "Type": "System.String"
                    },
                    "25": {
                        "Name": "student_id",
                        "NameInSource": "student_id",
                        "Alias": "student_id",
                        "Type": "System.Int32"
                    },
                    "26": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "27": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    },
                    "28": {
                        "Name": "amount_for_admission_fee",
                        "NameInSource": "amount_for_admission_fee",
                        "Alias": "amount_for_admission_fee",
                        "Type": "System.Int32"
                    },
                    "29": {
                        "Name": "amount_for_refundable_deposit",
                        "NameInSource": "amount_for_refundable_deposit",
                        "Alias": "amount_for_refundable_deposit",
                        "Type": "System.Int32"
                    },
                    "30": {
                        "Name": "amount_for_term_fee",
                        "NameInSource": "amount_for_term_fee",
                        "Alias": "amount_for_term_fee",
                        "Type": "System.Int32"
                    },
                    "31": {
                        "Name": "amount",
                        "NameInSource": "amount",
                        "Alias": "amount",
                        "Type": "System.Int32"
                    },
                    "32": {
                        "Name": "admission_fee_settlement",
                        "NameInSource": "admission_fee_settlement",
                        "Alias": "admission_fee_settlement",
                        "Type": "System.Int32"
                    },
                    "33": {
                        "Name": "refundable_deposit_settlement",
                        "NameInSource": "refundable_deposit_settlement",
                        "Alias": "refundable_deposit_settlement",
                        "Type": "System.Int32"
                    },
                    "34": {
                        "Name": "term_fee_settlement",
                        "NameInSource": "term_fee_settlement",
                        "Alias": "term_fee_settlement",
                        "Type": "System.Int32"
                    },
                    "35": {
                        "Name": "old_bill_number",
                        "NameInSource": "old_bill_number",
                        "Alias": "old_bill_number",
                        "Type": "System.Int32"
                    },
                    "36": {
                        "Name": "remarks",
                        "NameInSource": "remarks",
                        "Alias": "remarks",
                        "Type": "System.String"
                    },
                    "37": {
                        "Name": "receipt_voucher_type",
                        "NameInSource": "receipt_voucher_type",
                        "Alias": "receipt_voucher_type",
                        "Type": "System.String"
                    },
                    "38": {
                        "Name": "exam_bill_id",
                        "NameInSource": "exam_bill_id",
                        "Alias": "exam_bill_id",
                        "Type": "System.Int32"
                    },
                    "39": {
                        "Name": "exam_private_candidate_id",
                        "NameInSource": "exam_private_candidate_id",
                        "Alias": "exam_private_candidate_id",
                        "Type": "System.Int32"
                    },
                    "40": {
                        "Name": "private_candidate_id",
                        "NameInSource": "private_candidate_id",
                        "Alias": "private_candidate_id",
                        "Type": "System.Int32"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from receipt_voucher where id = {receipt_voucher_id}"
            },
            "4": {
                "Ident": "StiPostgreSQLSource",
                "Name": "student",
                "Alias": "student",
                "Key": "1113adc8e6ed41799484f284e670aa4f",
                "Columns": {
                    "0": {
                        "Name": "admission_fee_discount_percentage",
                        "NameInSource": "admission_fee_discount_percentage",
                        "Alias": "admission_fee_discount_percentage",
                        "Type": "System.String"
                    },
                    "1": {
                        "Name": "admission_number",
                        "NameInSource": "admission_number",
                        "Alias": "admission_number",
                        "Type": "System.String"
                    },
                    "2": {
                        "Name": "applicable_refundable_deposit",
                        "NameInSource": "applicable_refundable_deposit",
                        "Alias": "applicable_refundable_deposit",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "applicable_term_payment",
                        "NameInSource": "applicable_term_payment",
                        "Alias": "applicable_term_payment",
                        "Type": "System.Int32"
                    },
                    "4": {
                        "Name": "applicable_year_payment",
                        "NameInSource": "applicable_year_payment",
                        "Alias": "applicable_year_payment",
                        "Type": "System.Int32"
                    },
                    "5": {
                        "Name": "applicant_id",
                        "NameInSource": "applicant_id",
                        "Alias": "applicant_id",
                        "Type": "System.Int32"
                    },
                    "6": {
                        "Name": "approved_admission_fee",
                        "NameInSource": "approved_admission_fee",
                        "Alias": "approved_admission_fee",
                        "Type": "System.Int32"
                    },
                    "7": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "8": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "9": {
                        "Name": "date_of_birth",
                        "NameInSource": "date_of_birth",
                        "Alias": "date_of_birth",
                        "Type": "System.DateTime"
                    },
                    "10": {
                        "Name": "email",
                        "NameInSource": "email",
                        "Alias": "email",
                        "Type": "System.String"
                    },
                    "11": {
                        "Name": "full_address",
                        "NameInSource": "full_address",
                        "Alias": "full_address",
                        "Type": "System.String"
                    },
                    "12": {
                        "Name": "full_name",
                        "NameInSource": "full_name",
                        "Alias": "full_name",
                        "Type": "System.String"
                    },
                    "13": {
                        "Name": "full_name_with_title",
                        "NameInSource": "full_name_with_title",
                        "Alias": "full_name_with_title",
                        "Type": "System.String"
                    },
                    "14": {
                        "Name": "gender",
                        "NameInSource": "gender",
                        "Alias": "gender",
                        "Type": "System.String"
                    },
                    "15": {
                        "Name": "grade_level_class_id",
                        "NameInSource": "grade_level_class_id",
                        "Alias": "grade_level_class_id",
                        "Type": "System.Int32"
                    },
                    "16": {
                        "Name": "grade_level_id",
                        "NameInSource": "grade_level_id",
                        "Alias": "grade_level_id",
                        "Type": "System.Int32"
                    },
                    "17": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "18": {
                        "Name": "joined_date",
                        "NameInSource": "joined_date",
                        "Alias": "joined_date",
                        "Type": "System.DateTime"
                    },
                    "19": {
                        "Name": "nationality_id",
                        "NameInSource": "nationality_id",
                        "Alias": "nationality_id",
                        "Type": "System.Int32"
                    },
                    "20": {
                        "Name": "phone",
                        "NameInSource": "phone",
                        "Alias": "phone",
                        "Type": "System.String"
                    },
                    "21": {
                        "Name": "religion_id",
                        "NameInSource": "religion_id",
                        "Alias": "religion_id",
                        "Type": "System.Int32"
                    },
                    "22": {
                        "Name": "school_studied_before",
                        "NameInSource": "school_studied_before",
                        "Alias": "school_studied_before",
                        "Type": "System.String"
                    },
                    "23": {
                        "Name": "special_conditions",
                        "NameInSource": "special_conditions",
                        "Alias": "special_conditions",
                        "Type": "System.String"
                    },
                    "24": {
                        "Name": "student_admission_source_id",
                        "NameInSource": "student_admission_source_id",
                        "Alias": "student_admission_source_id",
                        "Type": "System.Int32"
                    },
                    "25": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "26": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    },
                    "27": {
                        "Name": "school_house_id",
                        "NameInSource": "school_house_id",
                        "Alias": "school_house_id",
                        "Type": "System.Int32"
                    },
                    "28": {
                        "Name": "has_dropped_out",
                        "NameInSource": "has_dropped_out",
                        "Alias": "has_dropped_out",
                        "Type": "System.Boolean"
                    },
                    "29": {
                        "Name": "admission_number_digits",
                        "NameInSource": "admission_number_digits",
                        "Alias": "admission_number_digits",
                        "Type": "System.Int32"
                    },
                    "30": {
                        "Name": "admission_number_prefix",
                        "NameInSource": "admission_number_prefix",
                        "Alias": "admission_number_prefix",
                        "Type": "System.String"
                    },
                    "31": {
                        "Name": "admission_number_current_year",
                        "NameInSource": "admission_number_current_year",
                        "Alias": "admission_number_current_year",
                        "Type": "System.String"
                    },
                    "32": {
                        "Name": "student_admission_source_other",
                        "NameInSource": "student_admission_source_other",
                        "Alias": "student_admission_source_other",
                        "Type": "System.String"
                    },
                    "33": {
                        "Name": "father_full_name",
                        "NameInSource": "father_full_name",
                        "Alias": "father_full_name",
                        "Type": "System.String"
                    },
                    "34": {
                        "Name": "father_id_type",
                        "NameInSource": "father_id_type",
                        "Alias": "father_id_type",
                        "Type": "System.String"
                    },
                    "35": {
                        "Name": "father_nic_number",
                        "NameInSource": "father_nic_number",
                        "Alias": "father_nic_number",
                        "Type": "System.String"
                    },
                    "36": {
                        "Name": "father_passport_number",
                        "NameInSource": "father_passport_number",
                        "Alias": "father_passport_number",
                        "Type": "System.String"
                    },
                    "37": {
                        "Name": "father_phone",
                        "NameInSource": "father_phone",
                        "Alias": "father_phone",
                        "Type": "System.String"
                    },
                    "38": {
                        "Name": "father_whatsapp",
                        "NameInSource": "father_whatsapp",
                        "Alias": "father_whatsapp",
                        "Type": "System.String"
                    },
                    "39": {
                        "Name": "father_email",
                        "NameInSource": "father_email",
                        "Alias": "father_email",
                        "Type": "System.String"
                    },
                    "40": {
                        "Name": "father_occupation",
                        "NameInSource": "father_occupation",
                        "Alias": "father_occupation",
                        "Type": "System.String"
                    },
                    "41": {
                        "Name": "father_place_of_work",
                        "NameInSource": "father_place_of_work",
                        "Alias": "father_place_of_work",
                        "Type": "System.String"
                    },
                    "42": {
                        "Name": "father_monthly_income",
                        "NameInSource": "father_monthly_income",
                        "Alias": "father_monthly_income",
                        "Type": "System.String"
                    },
                    "43": {
                        "Name": "mother_full_name",
                        "NameInSource": "mother_full_name",
                        "Alias": "mother_full_name",
                        "Type": "System.String"
                    },
                    "44": {
                        "Name": "mother_id_type",
                        "NameInSource": "mother_id_type",
                        "Alias": "mother_id_type",
                        "Type": "System.String"
                    },
                    "45": {
                        "Name": "mother_nic_number",
                        "NameInSource": "mother_nic_number",
                        "Alias": "mother_nic_number",
                        "Type": "System.String"
                    },
                    "46": {
                        "Name": "mother_passport_number",
                        "NameInSource": "mother_passport_number",
                        "Alias": "mother_passport_number",
                        "Type": "System.String"
                    },
                    "47": {
                        "Name": "mother_phone",
                        "NameInSource": "mother_phone",
                        "Alias": "mother_phone",
                        "Type": "System.String"
                    },
                    "48": {
                        "Name": "mother_whatsapp",
                        "NameInSource": "mother_whatsapp",
                        "Alias": "mother_whatsapp",
                        "Type": "System.String"
                    },
                    "49": {
                        "Name": "mother_email",
                        "NameInSource": "mother_email",
                        "Alias": "mother_email",
                        "Type": "System.String"
                    },
                    "50": {
                        "Name": "mother_occupation",
                        "NameInSource": "mother_occupation",
                        "Alias": "mother_occupation",
                        "Type": "System.String"
                    },
                    "51": {
                        "Name": "mother_place_of_work",
                        "NameInSource": "mother_place_of_work",
                        "Alias": "mother_place_of_work",
                        "Type": "System.String"
                    },
                    "52": {
                        "Name": "mother_monthly_income",
                        "NameInSource": "mother_monthly_income",
                        "Alias": "mother_monthly_income",
                        "Type": "System.String"
                    },
                    "53": {
                        "Name": "guardian_full_name",
                        "NameInSource": "guardian_full_name",
                        "Alias": "guardian_full_name",
                        "Type": "System.String"
                    },
                    "54": {
                        "Name": "guardian_id_type",
                        "NameInSource": "guardian_id_type",
                        "Alias": "guardian_id_type",
                        "Type": "System.String"
                    },
                    "55": {
                        "Name": "guardian_nic_number",
                        "NameInSource": "guardian_nic_number",
                        "Alias": "guardian_nic_number",
                        "Type": "System.String"
                    },
                    "56": {
                        "Name": "guardian_passport_number",
                        "NameInSource": "guardian_passport_number",
                        "Alias": "guardian_passport_number",
                        "Type": "System.String"
                    },
                    "57": {
                        "Name": "guardian_phone",
                        "NameInSource": "guardian_phone",
                        "Alias": "guardian_phone",
                        "Type": "System.String"
                    },
                    "58": {
                        "Name": "guardian_whatsapp",
                        "NameInSource": "guardian_whatsapp",
                        "Alias": "guardian_whatsapp",
                        "Type": "System.String"
                    },
                    "59": {
                        "Name": "guardian_email",
                        "NameInSource": "guardian_email",
                        "Alias": "guardian_email",
                        "Type": "System.String"
                    },
                    "60": {
                        "Name": "guardian_occupation",
                        "NameInSource": "guardian_occupation",
                        "Alias": "guardian_occupation",
                        "Type": "System.String"
                    },
                    "61": {
                        "Name": "guardian_place_of_work",
                        "NameInSource": "guardian_place_of_work",
                        "Alias": "guardian_place_of_work",
                        "Type": "System.String"
                    },
                    "62": {
                        "Name": "guardian_monthly_income",
                        "NameInSource": "guardian_monthly_income",
                        "Alias": "guardian_monthly_income",
                        "Type": "System.String"
                    },
                    "63": {
                        "Name": "student_phone",
                        "NameInSource": "student_phone",
                        "Alias": "student_phone",
                        "Type": "System.String"
                    },
                    "64": {
                        "Name": "student_email",
                        "NameInSource": "student_email",
                        "Alias": "student_email",
                        "Type": "System.String"
                    },
                    "65": {
                        "Name": "blood_group",
                        "NameInSource": "blood_group",
                        "Alias": "blood_group",
                        "Type": "System.String"
                    },
                    "66": {
                        "Name": "special_health_conditions",
                        "NameInSource": "special_health_conditions",
                        "Alias": "special_health_conditions",
                        "Type": "System.String"
                    },
                    "67": {
                        "Name": "student_address",
                        "NameInSource": "student_address",
                        "Alias": "student_address",
                        "Type": "System.String"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from student"
            },
            "5": {
                "Ident": "StiPostgreSQLSource",
                "Name": "applicant",
                "Alias": "applicant",
                "Key": "9f2f7c17b8494228bd219fc4adbb8f41",
                "Columns": {
                    "0": {
                        "Name": "gender",
                        "NameInSource": "gender",
                        "Alias": "gender",
                        "Type": "System.String"
                    },
                    "1": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "special_conditions",
                        "NameInSource": "special_conditions",
                        "Alias": "special_conditions",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "full_name",
                        "NameInSource": "full_name",
                        "Alias": "full_name",
                        "Type": "System.String"
                    },
                    "5": {
                        "Name": "nationality_id",
                        "NameInSource": "nationality_id",
                        "Alias": "nationality_id",
                        "Type": "System.Int32"
                    },
                    "6": {
                        "Name": "grade_level_id",
                        "NameInSource": "grade_level_id",
                        "Alias": "grade_level_id",
                        "Type": "System.Int32"
                    },
                    "7": {
                        "Name": "religion_id",
                        "NameInSource": "religion_id",
                        "Alias": "religion_id",
                        "Type": "System.Int32"
                    },
                    "8": {
                        "Name": "date_of_birth",
                        "NameInSource": "date_of_birth",
                        "Alias": "date_of_birth",
                        "Type": "System.DateTime"
                    },
                    "9": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "10": {
                        "Name": "applicant_number_current_year",
                        "NameInSource": "applicant_number_current_year",
                        "Alias": "applicant_number_current_year",
                        "Type": "System.String"
                    },
                    "11": {
                        "Name": "full_name_with_title",
                        "NameInSource": "full_name_with_title",
                        "Alias": "full_name_with_title",
                        "Type": "System.String"
                    },
                    "12": {
                        "Name": "school_studied_before",
                        "NameInSource": "school_studied_before",
                        "Alias": "school_studied_before",
                        "Type": "System.String"
                    },
                    "13": {
                        "Name": "applicant_number_digits",
                        "NameInSource": "applicant_number_digits",
                        "Alias": "applicant_number_digits",
                        "Type": "System.Int32"
                    },
                    "14": {
                        "Name": "applicant_number_prefix",
                        "NameInSource": "applicant_number_prefix",
                        "Alias": "applicant_number_prefix",
                        "Type": "System.String"
                    },
                    "15": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "16": {
                        "Name": "phone",
                        "NameInSource": "phone",
                        "Alias": "phone",
                        "Type": "System.String"
                    },
                    "17": {
                        "Name": "applicant_number",
                        "NameInSource": "applicant_number",
                        "Alias": "applicant_number",
                        "Type": "System.String"
                    },
                    "18": {
                        "Name": "email",
                        "NameInSource": "email",
                        "Alias": "email",
                        "Type": "System.String"
                    },
                    "19": {
                        "Name": "full_address",
                        "NameInSource": "full_address",
                        "Alias": "full_address",
                        "Type": "System.String"
                    },
                    "20": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "21": {
                        "Name": "has_converted_to_student",
                        "NameInSource": "has_converted_to_student",
                        "Alias": "has_converted_to_student",
                        "Type": "System.Boolean"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from applicant"
            },
            "6": {
                "Ident": "StiPostgreSQLSource",
                "Name": "exam_bill",
                "Alias": "exam_bill",
                "Columns": {
                    "0": {
                        "Name": "bill_notes",
                        "NameInSource": "bill_notes",
                        "Alias": "bill_notes",
                        "Type": "System.String"
                    },
                    "1": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "2": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "3": {
                        "Name": "date",
                        "NameInSource": "date",
                        "Alias": "date",
                        "Type": "System.DateTime"
                    },
                    "4": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "5": {
                        "Name": "office_notes",
                        "NameInSource": "office_notes",
                        "Alias": "office_notes",
                        "Type": "System.String"
                    },
                    "6": {
                        "Name": "serial_number",
                        "NameInSource": "serial_number",
                        "Alias": "serial_number",
                        "Type": "System.String"
                    },
                    "7": {
                        "Name": "serial_number_current_year",
                        "NameInSource": "serial_number_current_year",
                        "Alias": "serial_number_current_year",
                        "Type": "System.Int32"
                    },
                    "8": {
                        "Name": "serial_number_digits",
                        "NameInSource": "serial_number_digits",
                        "Alias": "serial_number_digits",
                        "Type": "System.Int32"
                    },
                    "9": {
                        "Name": "serial_number_financial_year",
                        "NameInSource": "serial_number_financial_year",
                        "Alias": "serial_number_financial_year",
                        "Type": "System.String"
                    },
                    "10": {
                        "Name": "serial_number_prefix",
                        "NameInSource": "serial_number_prefix",
                        "Alias": "serial_number_prefix",
                        "Type": "System.String"
                    },
                    "11": {
                        "Name": "serial_number_suffix",
                        "NameInSource": "serial_number_suffix",
                        "Alias": "serial_number_suffix",
                        "Type": "System.String"
                    },
                    "12": {
                        "Name": "student_id",
                        "NameInSource": "student_id",
                        "Alias": "student_id",
                        "Type": "System.Int32"
                    },
                    "13": {
                        "Name": "subtotal",
                        "NameInSource": "subtotal",
                        "Alias": "subtotal",
                        "Type": "System.Int32"
                    },
                    "14": {
                        "Name": "total",
                        "NameInSource": "total",
                        "Alias": "total",
                        "Type": "System.Int32"
                    },
                    "15": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "16": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    },
                    "17": {
                        "Name": "bill_party",
                        "NameInSource": "bill_party",
                        "Alias": "bill_party",
                        "Type": "System.String"
                    },
                    "18": {
                        "Name": "exam_private_candidate_id",
                        "NameInSource": "exam_private_candidate_id",
                        "Alias": "exam_private_candidate_id",
                        "Type": "System.Int32"
                    },
                    "19": {
                        "Name": "additional_service_charge",
                        "NameInSource": "additional_service_charge",
                        "Alias": "additional_service_charge",
                        "Type": "System.Int32"
                    },
                    "20": {
                        "Name": "exam_bill_discount",
                        "NameInSource": "exam_bill_discount",
                        "Alias": "exam_bill_discount",
                        "Type": "System.Int32"
                    },
                    "21": {
                        "Name": "exam_subjects_total",
                        "NameInSource": "exam_subjects_total",
                        "Alias": "exam_subjects_total",
                        "Type": "System.Int32"
                    },
                    "22": {
                        "Name": "exam_service_charges_total",
                        "NameInSource": "exam_service_charges_total",
                        "Alias": "exam_service_charges_total",
                        "Type": "System.Int32"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from exam_bill"
            },
            "7": {
                "Ident": "StiPostgreSQLSource",
                "Name": "user",
                "Alias": "user",
                "Columns": {
                    "0": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "1": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "email",
                        "NameInSource": "email",
                        "Alias": "email",
                        "Type": "System.String"
                    },
                    "3": {
                        "Name": "email_verified_at",
                        "NameInSource": "email_verified_at",
                        "Alias": "email_verified_at",
                        "Type": "System.DateTime"
                    },
                    "4": {
                        "Name": "full_name",
                        "NameInSource": "full_name",
                        "Alias": "full_name",
                        "Type": "System.String"
                    },
                    "5": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "6": {
                        "Name": "is_system_update_pending",
                        "NameInSource": "is_system_update_pending",
                        "Alias": "is_system_update_pending",
                        "Type": "System.Boolean"
                    },
                    "7": {
                        "Name": "password",
                        "NameInSource": "password",
                        "Alias": "password",
                        "Type": "System.String"
                    },
                    "8": {
                        "Name": "password_new",
                        "NameInSource": "password_new",
                        "Alias": "password_new",
                        "Type": "System.String"
                    },
                    "9": {
                        "Name": "remember_token",
                        "NameInSource": "remember_token",
                        "Alias": "remember_token",
                        "Type": "System.String"
                    },
                    "10": {
                        "Name": "update_by",
                        "NameInSource": "update_by",
                        "Alias": "update_by",
                        "Type": "System.Int32"
                    },
                    "11": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "12": {
                        "Name": "username",
                        "NameInSource": "username",
                        "Alias": "username",
                        "Type": "System.String"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from \"user\""
            },
            "8": {
                "Ident": "StiPostgreSQLSource",
                "Name": "exam_private_candidate",
                "Alias": "exam_private_candidate",
                "Columns": {
                    "0": {
                        "Name": "created_at",
                        "NameInSource": "created_at",
                        "Alias": "created_at",
                        "Type": "System.DateTime"
                    },
                    "1": {
                        "Name": "created_by",
                        "NameInSource": "created_by",
                        "Alias": "created_by",
                        "Type": "System.Int32"
                    },
                    "2": {
                        "Name": "exam_private_candidate_number",
                        "NameInSource": "exam_private_candidate_number",
                        "Alias": "exam_private_candidate_number",
                        "Type": "System.String"
                    },
                    "3": {
                        "Name": "exam_private_candidate_number_current_year",
                        "NameInSource": "exam_private_candidate_number_current_year",
                        "Alias": "exam_private_candidate_number_current_year",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "exam_private_candidate_number_digits",
                        "NameInSource": "exam_private_candidate_number_digits",
                        "Alias": "exam_private_candidate_number_digits",
                        "Type": "System.Int32"
                    },
                    "5": {
                        "Name": "exam_private_candidate_number_prefix",
                        "NameInSource": "exam_private_candidate_number_prefix",
                        "Alias": "exam_private_candidate_number_prefix",
                        "Type": "System.String"
                    },
                    "6": {
                        "Name": "full_name",
                        "NameInSource": "full_name",
                        "Alias": "full_name",
                        "Type": "System.String"
                    },
                    "7": {
                        "Name": "full_name_with_title",
                        "NameInSource": "full_name_with_title",
                        "Alias": "full_name_with_title",
                        "Type": "System.String"
                    },
                    "8": {
                        "Name": "gender",
                        "NameInSource": "gender",
                        "Alias": "gender",
                        "Type": "System.String"
                    },
                    "9": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int32"
                    },
                    "10": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "11": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int32"
                    },
                    "12": {
                        "Name": "phone",
                        "NameInSource": "phone",
                        "Alias": "phone",
                        "Type": "System.String"
                    },
                    "13": {
                        "Name": "email",
                        "NameInSource": "email",
                        "Alias": "email",
                        "Type": "System.String"
                    },
                    "14": {
                        "Name": "address",
                        "NameInSource": "address",
                        "Alias": "address",
                        "Type": "System.String"
                    },
                    "15": {
                        "Name": "student_admission_source_id",
                        "NameInSource": "student_admission_source_id",
                        "Alias": "student_admission_source_id",
                        "Type": "System.Int32"
                    },
                    "16": {
                        "Name": "student_admission_source_other",
                        "NameInSource": "student_admission_source_other",
                        "Alias": "student_admission_source_other",
                        "Type": "System.String"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from exam_private_candidate"
            }
        },
        "Databases": {
            "0": {
                "Ident": "StiPostgreSQLDatabase",
                "Name": "PostgreSQL",
                "Alias": "PostgreSQL",
                "Key": "2bedc1f857d04aee8504419e83221266",
                "CastToColumnType": "CastToColumnType",
                "ConnectionStringEncrypted": "49DZCcZV45FiFf3Yy1jiXot4aS1mV3vdRVqh8eQV7GfGVLOMZVwijMx37YTKJWRnxF7XCU9UiIxiXKGJYQh3L5Bs2cLvFluA"
            }
        },
        "Relations": {
            "0": {
                "Name": "bank_account",
                "ChildColumns": {
                    "0": "bank_account_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "bank_account",
                "Alias": "bank_account",
                "ParentSource": "bank_account",
                "ChildSource": "receipt_voucher"
            },
            "1": {
                "Name": "cash_account",
                "ChildColumns": {
                    "0": "cash_account_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "cash_account",
                "Alias": "cash_account",
                "ParentSource": "cash_account",
                "ChildSource": "receipt_voucher"
            },
            "2": {
                "Name": "student",
                "ChildColumns": {
                    "0": "student_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "student",
                "Alias": "student",
                "ParentSource": "student",
                "ChildSource": "receipt_voucher"
            },
            "3": {
                "Name": "applicant",
                "ChildColumns": {
                    "0": "applicant_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "Relation",
                "Alias": "applicant",
                "ParentSource": "applicant",
                "ChildSource": "receipt_voucher"
            },
            "4": {
                "Name": "exam_bill",
                "ChildColumns": {
                    "0": "exam_bill_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "exam_bill",
                "Alias": "exam_bill",
                "ParentSource": "exam_bill",
                "ChildSource": "receipt_voucher"
            },
            "5": {
                "Name": "user",
                "ChildColumns": {
                    "0": "payment_received_by_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "user",
                "Alias": "user",
                "ParentSource": "user",
                "ChildSource": "receipt_voucher"
            },
            "6": {
                "Name": "exam_private_candidate",
                "ChildColumns": {
                    "0": "exam_private_candidate_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "exam_private_candidate",
                "Alias": "exam_private_candidate",
                "ParentSource": "exam_private_candidate",
                "ChildSource": "receipt_voucher"
            },
            "7": {
                "Name": "private_candidate",
                "ChildColumns": {
                    "0": "private_candidate_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "private_candidate",
                "Alias": "private_candidate",
                "ParentSource": "exam_private_candidate",
                "ChildSource": "receipt_voucher"
            }
        }
    },
    "Pages": {
        "0": {
            "Ident": "StiPage",
            "Name": "Page1",
            "Guid": "8f656f441095463eae730f959911dad0",
            "Interaction": {
                "Ident": "StiInteraction"
            },
            "Border": ";;2;;;;;solid:Black",
            "Brush": "solid:",
            "Components": {
                "0": {
                    "Ident": "StiPageHeaderBand",
                    "Name": "PageHeaderBand1",
                    "CanGrow": true,
                    "ClientRectangle": "0,20,827,220",
                    "Interaction": {
                        "Ident": "StiInteraction"
                    },
                    "Border": ";;;;;;;solid:Black",
                    "Brush": "solid:",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text29",
                            "ClientRectangle": "35,130,750,30",
                            "ComponentStyle": "Aqua Company Name",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "RECEIPT VOUCHER"
                            },
                            "HorAlignment": "Center",
                            "Font": "Microsoft Sans Serif;18;Bold;",
                            "Border": ";155,155,155;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Gray",
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiText",
                            "Name": "Text61",
                            "ClientRectangle": "40,190,40,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "S/N: "
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:127,127,127",
                            "Type": "Expression"
                        },
                        "2": {
                            "Ident": "StiText",
                            "Name": "Text62",
                            "ClientRectangle": "70,190,190,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{receipt_voucher.serial_number}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "DataColumn"
                        },
                        "3": {
                            "Ident": "StiText",
                            "Name": "Text60",
                            "ClientRectangle": "650,190,70,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "Print Date: "
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:127,127,127",
                            "Type": "Expression"
                        },
                        "4": {
                            "Ident": "StiText",
                            "Name": "Text72",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "710,190,80,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{(Today).ToString(\"d MMM yyyy\")}"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextQuality": "Wysiwyg",
                            "AllowHtmlTags": true,
                            "Type": "Expression"
                        },
                        "5": {
                            "Ident": "StiText",
                            "Name": "Text12",
                            "Guid": "0e649ac5d6c4d91177171d0443b0240b",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "35,55,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "NEXIS COLLEGE INTERNATIONAL"
                            },
                            "HorAlignment": "Center",
                            "Font": ";10;Bold;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextFormat": {
                                "Ident": "StiNumberFormatService",
                                "NegativePattern": 1,
                                "DecimalDigits": 2,
                                "GroupSeparator": ","
                            },
                            "Type": "Expression"
                        },
                        "6": {
                            "Ident": "StiText",
                            "Name": "Text13",
                            "Guid": "886101405176074c3b4e4d6883fa7dc9",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "34.71,75,750,30",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "131 E, Kirindiwela Road ,Yakkala\nHotline : +94 337 140 150, +94 707 178 474, +94 772 330 108 | Email: info@nexiscollege.lk | Website: nexiscollege.lk"
                            },
                            "HorAlignment": "Center",
                            "Font": ";7;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextFormat": {
                                "Ident": "StiNumberFormatService",
                                "NegativePattern": 1,
                                "DecimalDigits": 2,
                                "GroupSeparator": ","
                            },
                            "Type": "Expression"
                        },
                        "7": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive2",
                            "Guid": "143bae59f9b549bdb8e0295b8b1998e1",
                            "ClientRectangle": "39.41,210.59,750,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    }
                },
                "1": {
                    "Ident": "StiPageFooterBand",
                    "Name": "PageFooterBand2",
                    "CanGrow": true,
                    "ClientRectangle": "0,1159,827,10",
                    "Interaction": {
                        "Ident": "StiInteraction"
                    },
                    "Border": ";;;;;;;solid:Black",
                    "Brush": "solid:"
                },
                "2": {
                    "Ident": "StiDataBand",
                    "Name": "DataBand3",
                    "Guid": "aa4e00adcc00416ea90e9b4ac24d113d",
                    "CanGrow": true,
                    "ClientRectangle": "0,280,827,110",
                    "Interaction": {
                        "Ident": "StiBandInteraction"
                    },
                    "Border": ";43,43,43;;;;;;solid:Black",
                    "Brush": "empty",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text2",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,65,750,20",
                            "Conditions": {
                                "0": {
                                    "Ident": "StiCondition",
                                    "Condition": "NotEqualTo",
                                    "Column": "receipt_voucher.receipt_party",
                                    "Value1": "Student",
                                    "Enabled": false,
                                    "BorderSides": "None"
                                }
                            },
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{receipt_voucher.student.full_name_with_title} ({receipt_voucher.student.admission_number})"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiText",
                            "Name": "Text24",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,65,750,20",
                            "Conditions": {
                                "0": {
                                    "Ident": "StiCondition",
                                    "Condition": "NotEqualTo",
                                    "Column": "receipt_voucher.receipt_party",
                                    "Value1": "Applicant",
                                    "Enabled": false,
                                    "BorderSides": "None"
                                }
                            },
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{receipt_voucher.applicant.full_name_with_title} ({receipt_voucher.applicant.applicant_number})"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "2": {
                            "Ident": "StiText",
                            "Name": "Text26",
                            "Guid": "7e5dd438c3d986899a7dbeec190fe636",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,65,750,40",
                            "Conditions": {
                                "0": {
                                    "Ident": "StiCondition",
                                    "Condition": "NotEqualTo",
                                    "Column": "receipt_voucher.receipt_party",
                                    "Value1": "Exam Private Candidate",
                                    "Enabled": false,
                                    "BorderSides": "None"
                                }
                            },
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{receipt_voucher.exam_private_candidate.full_name_with_title} ({receipt_voucher.exam_private_candidate.exam_private_candidate_number})"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "3": {
                            "Ident": "StiText",
                            "Name": "Text30",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,10,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Received an Amount of LKR {Replace(Format(\"{0:N}\", receipt_voucher.amount), \" \", \",\")}"
                            },
                            "HorAlignment": "Center",
                            "VertAlignment": "Bottom",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "4": {
                            "Ident": "StiText",
                            "Name": "Text1",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,40,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "From"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "5": {
                            "Ident": "StiText",
                            "Name": "Text25",
                            "Guid": "00b7b3d56b70f7460efda2293e6d3550",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,85,750,20",
                            "Conditions": {
                                "0": {
                                    "Ident": "StiCondition",
                                    "Condition": "NotEqualTo",
                                    "Column": "receipt_voucher.receipt_party",
                                    "Value1": "Exam Private Candidate",
                                    "Enabled": false,
                                    "BorderSides": "None"
                                }
                            },
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "For Exam Bill - {receipt_voucher.exam_bill.serial_number}"
                            },
                            "HorAlignment": "Center",
                            "VertAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "6": {
                            "Ident": "StiText",
                            "Name": "Text27",
                            "Guid": "aa37ab67a9143e15e4631ba73868c682",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,65,750,40",
                            "Conditions": {
                                "0": {
                                    "Ident": "StiCondition",
                                    "Condition": "NotEqualTo",
                                    "Column": "receipt_voucher.receipt_party",
                                    "Value1": "Private Candidate",
                                    "Enabled": false,
                                    "BorderSides": "None"
                                }
                            },
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{receipt_voucher.private_candidate.full_name_with_title} ({receipt_voucher.private_candidate.exam_private_candidate_number})"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        }
                    },
                    "PrintIfDetailEmpty": true,
                    "DataSourceName": "tblpayment_in"
                },
                "3": {
                    "Ident": "StiDataBand",
                    "Name": "DataBand1",
                    "Guid": "c608bd2af4bf44d6b376271dadb6dfe3",
                    "CanGrow": true,
                    "ClientRectangle": "0,430,827,70",
                    "Conditions": {
                        "0": {
                            "Ident": "StiMultiCondition",
                            "Enabled": false,
                            "BorderSides": "None",
                            "FilterMode": "Or",
                            "Filters": {
                                "0": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Bank Deposit"
                                },
                                "1": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Check"
                                }
                            }
                        }
                    },
                    "Interaction": {
                        "Ident": "StiBandInteraction"
                    },
                    "CanBreak": true,
                    "Border": ";43,43,43;;;;;;solid:Black",
                    "Brush": "empty",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text3",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "240,40,170,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{(receipt_voucher.cash_received_date).ToString(\"d MMM yyyy\")}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiText",
                            "Name": "Text4",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "35,10,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "Payment Method: Cash"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "2": {
                            "Ident": "StiText",
                            "Name": "Text6",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "470,40,80,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Received By:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "3": {
                            "Ident": "StiText",
                            "Name": "Text20",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "70,40,160,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Received Date:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextFormat": {
                                "Ident": "StiDateFormatService",
                                "StringFormat": "D"
                            },
                            "Type": "Expression"
                        },
                        "4": {
                            "Ident": "StiText",
                            "Name": "Text21",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "560,40,220,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{receipt_voucher.user.full_name}"
                            },
                            "CanBreak": true,
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextOptions": {
                                "WordWrap": true
                            },
                            "Type": "DataColumn"
                        },
                        "5": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive5",
                            "ClientRectangle": "39.41,70,750,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Color": "165,165,165",
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    },
                    "PrintIfDetailEmpty": true
                },
                "4": {
                    "Ident": "StiDataBand",
                    "Name": "DataBand2",
                    "Guid": "bf94e229c40244a4945680e6b1409553",
                    "CanGrow": true,
                    "ClientRectangle": "0,540,827,70",
                    "Conditions": {
                        "0": {
                            "Ident": "StiMultiCondition",
                            "Enabled": false,
                            "BorderSides": "None",
                            "FilterMode": "Or",
                            "Filters": {
                                "0": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Cash"
                                },
                                "1": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Check"
                                }
                            }
                        }
                    },
                    "Interaction": {
                        "Ident": "StiBandInteraction"
                    },
                    "Border": ";43,43,43;;;;;;solid:Black",
                    "Brush": "empty",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text5",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "240,40,170,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{(receipt_voucher.payment_received_date).ToString(\"d MMM yyyy\")}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiText",
                            "Name": "Text7",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "35,10,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "Payment Method: Bank Deposit"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "2": {
                            "Ident": "StiText",
                            "Name": "Text8",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "560,40,220,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{receipt_voucher.bank_account.name}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "DataColumn"
                        },
                        "3": {
                            "Ident": "StiText",
                            "Name": "Text22",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "60,40,170,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Bank Deposit Date:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextFormat": {
                                "Ident": "StiDateFormatService",
                                "StringFormat": "D"
                            },
                            "Type": "Expression"
                        },
                        "4": {
                            "Ident": "StiText",
                            "Name": "Text23",
                            "Guid": "e20eae1aa50010f41cc79a0483e68f54",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "440,40,110,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Bank Account:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "5": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive1",
                            "ClientRectangle": "39.41,70,750,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Color": "165,165,165",
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    },
                    "PrintIfDetailEmpty": true
                },
                "5": {
                    "Ident": "StiDataBand",
                    "Name": "DataBand4",
                    "Guid": "9b6d1864c806429582d3678719003e67",
                    "CanGrow": true,
                    "ClientRectangle": "0,650,827,100",
                    "Conditions": {
                        "0": {
                            "Ident": "StiMultiCondition",
                            "Enabled": false,
                            "BorderSides": "None",
                            "FilterMode": "Or",
                            "Filters": {
                                "0": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Cash"
                                },
                                "1": {
                                    "Ident": "StiFilter",
                                    "Column": "receipt_voucher.payment_method",
                                    "Value1": "Bank Deposit"
                                }
                            }
                        }
                    },
                    "Interaction": {
                        "Ident": "StiBandInteraction"
                    },
                    "Border": ";43,43,43;;;;;;solid:Black",
                    "Brush": "empty",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text9",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "240,40,150,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{(receipt_voucher.check_date).ToString(\"d MMM yyyy\")}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiText",
                            "Name": "Text10",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "35,10,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "Payment Method: Check"
                            },
                            "HorAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "2": {
                            "Ident": "StiText",
                            "Name": "Text11",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "560,40,220,30",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{receipt_voucher.user.full_name}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextOptions": {
                                "WordWrap": true
                            },
                            "Type": "DataColumn"
                        },
                        "3": {
                            "Ident": "StiText",
                            "Name": "Text14",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "240,70,150,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{receipt_voucher.check_number}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "DataColumn"
                        },
                        "4": {
                            "Ident": "StiText",
                            "Name": "Text15",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "560,70,220,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "{(receipt_voucher.check_received_date).ToString(\"d MMM yyyy\")}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "5": {
                            "Ident": "StiText",
                            "Name": "Text16",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "60,40,170,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Check Date:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "6": {
                            "Ident": "StiText",
                            "Name": "Text17",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "60,70,170,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Check Number:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "7": {
                            "Ident": "StiText",
                            "Name": "Text18",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "420,40,130,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Check Received By:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "8": {
                            "Ident": "StiText",
                            "Name": "Text19",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "420,70,130,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Received Date:"
                            },
                            "HorAlignment": "Right",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "9": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive3",
                            "ClientRectangle": "39.41,100,750,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Color": "165,165,165",
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    },
                    "PrintIfDetailEmpty": true
                },
                "6": {
                    "Ident": "StiReportSummaryBand",
                    "Name": "ReportSummaryBand1",
                    "CanShrink": true,
                    "CanGrow": true,
                    "ClientRectangle": "0,790,827,100",
                    "Interaction": {
                        "Ident": "StiInteraction"
                    },
                    "CanBreak": true,
                    "Border": ";;;;;;;solid:Black",
                    "Brush": "solid:",
                    "Components": {
                        "0": {
                            "Ident": "StiText",
                            "Name": "Text33",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "630,70,160,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "Issued By"
                            },
                            "HorAlignment": "Center",
                            "VertAlignment": "Center",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "TextOptions": {
                                "WordWrap": true
                            },
                            "Type": "Expression"
                        },
                        "1": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive4",
                            "Guid": "b668d6007d085efcf62064f85f4ad14d",
                            "ClientRectangle": "630,60,160,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    }
                }
            },
            "PaperSize": "A4",
            "Watermark": {
                "TextBrush": "solid:50,0,0,0"
            },
            "Margins": {
                "Left": 0,
                "Right": 0,
                "Top": 0,
                "Bottom": 0
            },
            "MirrorMargins": true
        }
    }
}