{
    "ReportVersion": "2025.1.1",
    "ReportGuid": "bf4115cc5a85b296a16bf82677fb1b13",
    "ReportName": "Receipt Voucher",
    "ReportAlias": "Receipt Voucher",
    "ReportFile": "/get-income-note-data-report.mrt",
    "ReportAuthor": "Solovo Systems",
    "ReportCreated": "/Date(0+0530)/",
    "ReportChanged": "/Date(1745421558000+0530)/",
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
                "Value": "1",
                "Name": "income_note_id",
                "DialogInfo": {
                    "DateTimeType": "DateAndTime",
                    "SortDirection": "None"
                },
                "Alias": "income_note_id",
                "Type": "System.Int32",
                "Key": "_x0037_93fc72e64e449ef8ec4f798ed34fb71"
            }
        },
        "DataSources": {
            "0": {
                "Ident": "StiPostgreSQLSource",
                "Name": "income_note",
                "Alias": "income_note",
                "Columns": {
                    "0": {
                        "Name": "amount",
                        "NameInSource": "amount",
                        "Alias": "amount",
                        "Type": "System.Decimal"
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
                        "Type": "System.Int64"
                    },
                    "3": {
                        "Name": "date",
                        "NameInSource": "date",
                        "Alias": "date",
                        "Type": "System.DateTime"
                    },
                    "4": {
                        "Name": "general_income_party_info",
                        "NameInSource": "general_income_party_info",
                        "Alias": "general_income_party_info",
                        "Type": "System.String"
                    },
                    "5": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int64"
                    },
                    "6": {
                        "Name": "income_category_id",
                        "NameInSource": "income_category_id",
                        "Alias": "income_category_id",
                        "Type": "System.Int64"
                    },
                    "7": {
                        "Name": "income_note_status_id",
                        "NameInSource": "income_note_status_id",
                        "Alias": "income_note_status_id",
                        "Type": "System.Int64"
                    },
                    "8": {
                        "Name": "income_party_id",
                        "NameInSource": "income_party_id",
                        "Alias": "income_party_id",
                        "Type": "System.Int64"
                    },
                    "9": {
                        "Name": "income_type_id",
                        "NameInSource": "income_type_id",
                        "Alias": "income_type_id",
                        "Type": "System.Int64"
                    },
                    "10": {
                        "Name": "is_income_note_complete",
                        "NameInSource": "is_income_note_complete",
                        "Alias": "is_income_note_complete",
                        "Type": "System.Boolean"
                    },
                    "11": {
                        "Name": "office_notes",
                        "NameInSource": "office_notes",
                        "Alias": "office_notes",
                        "Type": "System.String"
                    },
                    "12": {
                        "Name": "serial_number",
                        "NameInSource": "serial_number",
                        "Alias": "serial_number",
                        "Type": "System.String"
                    },
                    "13": {
                        "Name": "serial_number_current_year",
                        "NameInSource": "serial_number_current_year",
                        "Alias": "serial_number_current_year",
                        "Type": "System.Int64"
                    },
                    "14": {
                        "Name": "serial_number_digits",
                        "NameInSource": "serial_number_digits",
                        "Alias": "serial_number_digits",
                        "Type": "System.Int64"
                    },
                    "15": {
                        "Name": "serial_number_financial_year",
                        "NameInSource": "serial_number_financial_year",
                        "Alias": "serial_number_financial_year",
                        "Type": "System.String"
                    },
                    "16": {
                        "Name": "serial_number_prefix",
                        "NameInSource": "serial_number_prefix",
                        "Alias": "serial_number_prefix",
                        "Type": "System.String"
                    },
                    "17": {
                        "Name": "serial_number_suffix",
                        "NameInSource": "serial_number_suffix",
                        "Alias": "serial_number_suffix",
                        "Type": "System.String"
                    },
                    "18": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "19": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int64"
                    }
                },
                "NameInSource": "PostgreSQL",
                "CommandTimeout": 1,
                "SqlCommand": "select * from income_note where id = {income_note_id}"
            },
            "1": {
                "Ident": "StiPostgreSQLSource",
                "Name": "income_party",
                "Alias": "income_party",
                "Columns": {
                    "0": {
                        "Name": "country_id",
                        "NameInSource": "country_id",
                        "Alias": "country_id",
                        "Type": "System.Int64"
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
                        "Type": "System.Int64"
                    },
                    "3": {
                        "Name": "email",
                        "NameInSource": "email",
                        "Alias": "email",
                        "Type": "System.String"
                    },
                    "4": {
                        "Name": "full_address",
                        "NameInSource": "full_address",
                        "Alias": "full_address",
                        "Type": "System.String"
                    },
                    "5": {
                        "Name": "id",
                        "NameInSource": "id",
                        "Alias": "id",
                        "Type": "System.Int64"
                    },
                    "6": {
                        "Name": "income_party_type",
                        "NameInSource": "income_party_type",
                        "Alias": "income_party_type",
                        "Type": "System.String"
                    },
                    "7": {
                        "Name": "name",
                        "NameInSource": "name",
                        "Alias": "name",
                        "Type": "System.String"
                    },
                    "8": {
                        "Name": "name_with_title",
                        "NameInSource": "name_with_title",
                        "Alias": "name_with_title",
                        "Type": "System.String"
                    },
                    "9": {
                        "Name": "person_title_id",
                        "NameInSource": "person_title_id",
                        "Alias": "person_title_id",
                        "Type": "System.Int64"
                    },
                    "10": {
                        "Name": "phone",
                        "NameInSource": "phone",
                        "Alias": "phone",
                        "Type": "System.String"
                    },
                    "11": {
                        "Name": "serial_number",
                        "NameInSource": "serial_number",
                        "Alias": "serial_number",
                        "Type": "System.String"
                    },
                    "12": {
                        "Name": "serial_number_current_year",
                        "NameInSource": "serial_number_current_year",
                        "Alias": "serial_number_current_year",
                        "Type": "System.Int64"
                    },
                    "13": {
                        "Name": "serial_number_digits",
                        "NameInSource": "serial_number_digits",
                        "Alias": "serial_number_digits",
                        "Type": "System.Int64"
                    },
                    "14": {
                        "Name": "serial_number_prefix",
                        "NameInSource": "serial_number_prefix",
                        "Alias": "serial_number_prefix",
                        "Type": "System.String"
                    },
                    "15": {
                        "Name": "serial_number_suffix",
                        "NameInSource": "serial_number_suffix",
                        "Alias": "serial_number_suffix",
                        "Type": "System.String"
                    },
                    "16": {
                        "Name": "updated_at",
                        "NameInSource": "updated_at",
                        "Alias": "updated_at",
                        "Type": "System.DateTime"
                    },
                    "17": {
                        "Name": "updated_by",
                        "NameInSource": "updated_by",
                        "Alias": "updated_by",
                        "Type": "System.Int64"
                    }
                },
                "NameInSource": "PostgreSQL",
                "SqlCommand": "select * from income_party"
            }
        },
        "Databases": {
            "0": {
                "Ident": "StiPostgreSQLDatabase",
                "Name": "PostgreSQL",
                "Alias": "PostgreSQL",
                "Key": "2bedc1f857d04aee8504419e83221266",
                "CastToColumnType": "CastToColumnType",
                "ConnectionStringEncrypted": "49D/a01nS2BiFYSESz3hY4t40YNmBalZYk39gWoN7GLCWsmMY18x8OlY0NxqJWQqi1Sz6eMOYcjiTKzM6XQ="
            }
        },
        "Relations": {
            "0": {
                "Name": "income_party",
                "ChildColumns": {
                    "0": "income_party_id"
                },
                "ParentColumns": {
                    "0": "id"
                },
                "NameInSource": "Relation1",
                "Alias": "income_party",
                "ParentSource": "income_party",
                "ChildSource": "income_note"
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
                                "Value": "Income Note"
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
                                "Value": "{income_note.serial_number}"
                            },
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
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
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Text": {
                                "Value": "{income_note.income_party.name_with_title}"
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
                            "Name": "Text30",
                            "CanShrink": true,
                            "CanGrow": true,
                            "ClientRectangle": "38.5,10,750,20",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "Editable": true,
                            "Text": {
                                "Value": "Received an Amount of LKR {Replace(Format(\"{0:N}\", income_note.amount), \" \", \",\")}"
                            },
                            "HorAlignment": "Center",
                            "VertAlignment": "Bottom",
                            "Font": ";9;;",
                            "Border": ";;;;;;;solid:Black",
                            "Brush": "solid:",
                            "TextBrush": "solid:Black",
                            "Type": "Expression"
                        },
                        "2": {
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
                        "3": {
                            "Ident": "StiHorizontalLinePrimitive",
                            "Name": "HorizontalLinePrimitive1",
                            "Guid": "011f6f0c018095c16dc763714d723245",
                            "ClientRectangle": "39,101,750,1",
                            "Interaction": {
                                "Ident": "StiInteraction"
                            },
                            "StartCap": ";;;",
                            "EndCap": ";;;"
                        }
                    },
                    "PrintIfDetailEmpty": true,
                    "DataSourceName": "tblpayment_in"
                },
                "3": {
                    "Ident": "StiReportSummaryBand",
                    "Name": "ReportSummaryBand1",
                    "CanShrink": true,
                    "CanGrow": true,
                    "ClientRectangle": "0,430,827,100",
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