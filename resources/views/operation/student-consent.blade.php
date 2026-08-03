<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Helvetica;
            padding: 20px 30px;
        }

        p,
        li {
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
        }
    </style>

</head>

<body>

<img src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}" width="110">

<p style="text-align:right;line-height:1;margin:3px 0;">
    <b>GPS Education Solutions Inc.</b>
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Surrey Office - 15315 66 Ave Unit 308, Surrey, BC V3S 2A2
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Phone Number - (604) 771-5110
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Website - www.gpseducation.ca
</p>

<h4 style="text-align:center;">
    STUDENT CONSENT & RESPONSIBILITY LETTER
</h4>

<p style="margin-top:-15px;">
    To Whom It May Concern,
</p>

<p>
    I, the undersigned student, hereby confirm that GPS Education Solutions Inc.
    ("GPS Education") has provided me with general guidance and information
    regarding various academic programs and institutions. Based on this
    information, I hereby make the following declarations:
</p>

<ul style="list-style:decimal;padding-left:20px;">

<li>
    Voluntary Decision<br>

    I understand and acknowledge that the final decision regarding my choice of
    program, college, and location has been made solely by me, without any force,
    misrepresentation, or guarantee of outcome by GPS Education or its representatives.
</li>

<li>

    Responsibility for Documents Provided<br>

    I confirm that:

    <br>

    All documents (including but not limited to identification, academic records,
    immigration documents, and certifications) submitted to the educational institution
    have been provided solely by me.

    <br><br>

    I take full legal and personal responsibility for the authenticity,
    accuracy, and validity of the documents submitted.

    <br><br>

    GPS Education shall not be held responsible for any consequences resulting
    from submission of forged, altered, or invalid documentation.

</li>

<li>

    Student Responsibility for Academic Outcome

    <br>

    I take full personal responsibility for:

    <br>

    Pursuing the program I have selected.

    <br>

    Understanding all course requirements and institutional policies.

    <br>

    Maintaining compliance with attendance, conduct,
    and academic standards as required by the institution.

</li>

<li>

    Confidentiality and Access

    <br>

    I agree not to share my login credentials, student ID,
    or confidential academic information with any third party,
    including agents, friends, or family members.

    <br>

    I understand that any breach of this may result in
    academic or administrative consequences.

</li>

<li>

    Jurisdiction and Compliance

    <br>

    This agreement shall be governed by the laws of the
    Province of British Columbia.

    Any dispute arising from this agreement will fall under
    the jurisdiction of the courts within British Columbia.

</li>

</ul>

<p>
    Student Acknowledgement
</p>

<p style="margin:5px;">
    <span>Full Name:</span>
    <span style="text-decoration: underline;">
        {{ $student->sname ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Date of Birth:</span>
    <span style="text-decoration: underline;">
        {{ $student->dob ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Email ID:</span>
    <span style="text-decoration: underline;">
        {{ $student->semail ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Phone Number:</span>
    <span style="text-decoration: underline;">
        {{ $student->smobile ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Program & College Selected:</span>
    <span style="text-decoration: underline;">
        {{ $student->program_name ?? '' }}
        {{ $student->collage_name ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Signature of Student:</span>
    <span style="text-decoration: underline;">&nbsp;</span>
</p>

<p style="margin:5px;">
    <span>Date:</span>
    <span style="text-decoration: underline;">
        {{ now()->format('Y-m-d') }}
    </span>
</p>

</body>
</html><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Helvetica;
            padding: 20px 30px;
        }

        p,
        li {
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
        }
    </style>

</head>

<body>

<img src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}" width="110">

<p style="text-align:right;line-height:1;margin:3px 0;">
    <b>GPS Education Solutions Inc.</b>
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Surrey Office - 15315 66 Ave Unit 308, Surrey, BC V3S 2A2
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Phone Number - (604) 771-5110
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Website - www.gpseducation.ca
</p>

<h4 style="text-align:center;">
    STUDENT CONSENT & RESPONSIBILITY LETTER
</h4>

<p style="margin-top:-15px;">
    To Whom It May Concern,
</p>

<p>
    I, the undersigned student, hereby confirm that GPS Education Solutions Inc.
    ("GPS Education") has provided me with general guidance and information
    regarding various academic programs and institutions. Based on this
    information, I hereby make the following declarations:
</p>

<ul style="list-style:decimal;padding-left:20px;">

<li>
    Voluntary Decision<br>

    I understand and acknowledge that the final decision regarding my choice of
    program, college, and location has been made solely by me, without any force,
    misrepresentation, or guarantee of outcome by GPS Education or its representatives.
</li>

<li>

    Responsibility for Documents Provided<br>

    I confirm that:

    <br>

    All documents (including but not limited to identification, academic records,
    immigration documents, and certifications) submitted to the educational institution
    have been provided solely by me.

    <br><br>

    I take full legal and personal responsibility for the authenticity,
    accuracy, and validity of the documents submitted.

    <br><br>

    GPS Education shall not be held responsible for any consequences resulting
    from submission of forged, altered, or invalid documentation.

</li>

<li>

    Student Responsibility for Academic Outcome

    <br>

    I take full personal responsibility for:

    <br>

    Pursuing the program I have selected.

    <br>

    Understanding all course requirements and institutional policies.

    <br>

    Maintaining compliance with attendance, conduct,
    and academic standards as required by the institution.

</li>

<li>

    Confidentiality and Access

    <br>

    I agree not to share my login credentials, student ID,
    or confidential academic information with any third party,
    including agents, friends, or family members.

    <br>

    I understand that any breach of this may result in
    academic or administrative consequences.

</li>

<li>

    Jurisdiction and Compliance

    <br>

    This agreement shall be governed by the laws of the
    Province of British Columbia.

    Any dispute arising from this agreement will fall under
    the jurisdiction of the courts within British Columbia.

</li>

</ul>

<p>
    Student Acknowledgement
</p>

<p style="margin:5px;">
    <span>Full Name:</span>
    <span style="text-decoration: underline;">
        {{ $student->sname ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Date of Birth:</span>
    <span style="text-decoration: underline;">
        {{ $student->dob ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Email ID:</span>
    <span style="text-decoration: underline;">
        {{ $student->semail ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Phone Number:</span>
    <span style="text-decoration: underline;">
        {{ $student->smobile ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Program & College Selected:</span>
    <span style="text-decoration: underline;">
        {{ $student->program_name ?? '' }}
        {{ $student->collage_name ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Signature of Student:</span>
    <span style="text-decoration: underline;">&nbsp;</span>
</p>

<p style="margin:5px;">
    <span>Date:</span>
    <span style="text-decoration: underline;">
        {{ now()->format('Y-m-d') }}
    </span>
</p>

</body>
</html><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Helvetica;
            padding: 20px 30px;
        }

        p,
        li {
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
        }
    </style>

</head>

<body>

<img src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}" width="110">

<p style="text-align:right;line-height:1;margin:3px 0;">
    <b>GPS Education Solutions Inc.</b>
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Surrey Office - 15315 66 Ave Unit 308, Surrey, BC V3S 2A2
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Phone Number - (604) 771-5110
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Website - www.gpseducation.ca
</p>

<h4 style="text-align:center;">
    STUDENT CONSENT & RESPONSIBILITY LETTER
</h4>

<p style="margin-top:-15px;">
    To Whom It May Concern,
</p>

<p>
    I, the undersigned student, hereby confirm that GPS Education Solutions Inc.
    ("GPS Education") has provided me with general guidance and information
    regarding various academic programs and institutions. Based on this
    information, I hereby make the following declarations:
</p>

<ul style="list-style:decimal;padding-left:20px;">

<li>
    Voluntary Decision<br>

    I understand and acknowledge that the final decision regarding my choice of
    program, college, and location has been made solely by me, without any force,
    misrepresentation, or guarantee of outcome by GPS Education or its representatives.
</li>

<li>

    Responsibility for Documents Provided<br>

    I confirm that:

    <br>

    All documents (including but not limited to identification, academic records,
    immigration documents, and certifications) submitted to the educational institution
    have been provided solely by me.

    <br><br>

    I take full legal and personal responsibility for the authenticity,
    accuracy, and validity of the documents submitted.

    <br><br>

    GPS Education shall not be held responsible for any consequences resulting
    from submission of forged, altered, or invalid documentation.

</li>

<li>

    Student Responsibility for Academic Outcome

    <br>

    I take full personal responsibility for:

    <br>

    Pursuing the program I have selected.

    <br>

    Understanding all course requirements and institutional policies.

    <br>

    Maintaining compliance with attendance, conduct,
    and academic standards as required by the institution.

</li>

<li>

    Confidentiality and Access

    <br>

    I agree not to share my login credentials, student ID,
    or confidential academic information with any third party,
    including agents, friends, or family members.

    <br>

    I understand that any breach of this may result in
    academic or administrative consequences.

</li>

<li>

    Jurisdiction and Compliance

    <br>

    This agreement shall be governed by the laws of the
    Province of British Columbia.

    Any dispute arising from this agreement will fall under
    the jurisdiction of the courts within British Columbia.

</li>

</ul>

<p>
    Student Acknowledgement
</p>

<p style="margin:5px;">
    <span>Full Name:</span>
    <span style="text-decoration: underline;">
        {{ $student->sname ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Date of Birth:</span>
    <span style="text-decoration: underline;">
        {{ $student->dob ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Email ID:</span>
    <span style="text-decoration: underline;">
        {{ $student->semail ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Phone Number:</span>
    <span style="text-decoration: underline;">
        {{ $student->smobile ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Program & College Selected:</span>
    <span style="text-decoration: underline;">
        {{ $student->program_name ?? '' }}
        {{ $student->collage_name ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Signature of Student:</span>
    <span style="text-decoration: underline;">&nbsp;</span>
</p>

<p style="margin:5px;">
    <span>Date:</span>
    <span style="text-decoration: underline;">
        {{ now()->format('Y-m-d') }}
    </span>
</p>

</body>
</html><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Helvetica;
            padding: 20px 30px;
        }

        p,
        li {
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
        }
    </style>

</head>

<body>

<img src="{{ public_path('images/GPS-Logo.jpg.jpeg') }}" width="110">

<p style="text-align:right;line-height:1;margin:3px 0;">
    <b>GPS Education Solutions Inc.</b>
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Surrey Office - 15315 66 Ave Unit 308, Surrey, BC V3S 2A2
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Phone Number - (604) 771-5110
</p>

<p style="text-align:right;line-height:1;margin:3px 0;">
    Website - www.gpseducation.ca
</p>

<h4 style="text-align:center;">
    STUDENT CONSENT & RESPONSIBILITY LETTER
</h4>

<p style="margin-top:-15px;">
    To Whom It May Concern,
</p>

<p>
    I, the undersigned student, hereby confirm that GPS Education Solutions Inc.
    ("GPS Education") has provided me with general guidance and information
    regarding various academic programs and institutions. Based on this
    information, I hereby make the following declarations:
</p>

<ul style="list-style:decimal;padding-left:20px;">

<li>
    Voluntary Decision<br>

    I understand and acknowledge that the final decision regarding my choice of
    program, college, and location has been made solely by me, without any force,
    misrepresentation, or guarantee of outcome by GPS Education or its representatives.
</li>

<li>

    Responsibility for Documents Provided<br>

    I confirm that:

    <br>

    All documents (including but not limited to identification, academic records,
    immigration documents, and certifications) submitted to the educational institution
    have been provided solely by me.

    <br><br>

    I take full legal and personal responsibility for the authenticity,
    accuracy, and validity of the documents submitted.

    <br><br>

    GPS Education shall not be held responsible for any consequences resulting
    from submission of forged, altered, or invalid documentation.

</li>

<li>

    Student Responsibility for Academic Outcome

    <br>

    I take full personal responsibility for:

    <br>

    Pursuing the program I have selected.

    <br>

    Understanding all course requirements and institutional policies.

    <br>

    Maintaining compliance with attendance, conduct,
    and academic standards as required by the institution.

</li>

<li>

    Confidentiality and Access

    <br>

    I agree not to share my login credentials, student ID,
    or confidential academic information with any third party,
    including agents, friends, or family members.

    <br>

    I understand that any breach of this may result in
    academic or administrative consequences.

</li>

<li>

    Jurisdiction and Compliance

    <br>

    This agreement shall be governed by the laws of the
    Province of British Columbia.

    Any dispute arising from this agreement will fall under
    the jurisdiction of the courts within British Columbia.

</li>

</ul>

<p>
    Student Acknowledgement
</p>

<p style="margin:5px;">
    <span>Full Name:</span>
    <span style="text-decoration: underline;">
        {{ $student->sname ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Date of Birth:</span>
    <span style="text-decoration: underline;">
        {{ $student->dob ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Email ID:</span>
    <span style="text-decoration: underline;">
        {{ $student->semail ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Phone Number:</span>
    <span style="text-decoration: underline;">
        {{ $student->smobile ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Program & College Selected:</span>
    <span style="text-decoration: underline;">
        {{ $student->program_name ?? '' }}
        {{ $student->collage_name ?? '' }}
    </span>
</p>

<p style="margin:5px;">
    <span>Signature of Student:</span>
    <span style="text-decoration: underline;">&nbsp;</span>
</p>

<p style="margin:5px;">
    <span>Date:</span>
    <span style="text-decoration: underline;">
        {{ now()->format('Y-m-d') }}
    </span>
</p>

</body>
</html>