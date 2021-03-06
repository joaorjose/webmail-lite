<?php

class CApiMailMessage
{
	/**
	 * @var string
	 */
	protected $sFolder;

	/**
	 * @var int
	 */
	protected $iUid;

	/**
	 * @var string
	 */
	protected $sSubject;

	/**
	 * @var string
	 */
	protected $sMessageId;

	/**
	 * @var string
	 */
	protected $sContentType;

	/**
	 * @var int
	 */
	protected $iSize;

	/**
	 * @var int
	 */
	protected $iTextSize;

	/**
	 * @var int
	 */
	protected $iInternalTimeStampInUTC;

	/**
	 * @var int
	 */
	protected $iReceivedOrDateTimeStampInUTC;

	/**
	 * @var array
	 */
	protected $aFlags;

	/**
	 * @var array
	 */
	protected $aFlagsLowerCase;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oFrom;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oSender;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oReplyTo;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oTo;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oCc;

	/**
	 * @var \MailSo\Mime\EmailCollection
	 */
	protected $oBcc;

	/**
	 * @var string
	 */
	protected $sInReplyTo;

	/**
	 * @var string
	 */
	protected $sReferences;

	/**
	 * @var string
	 */
	protected $sTextPartID;

	/**
	 * @var string
	 */
	protected $sPlain;

	/**
	 * @var string
	 */
	protected $sHtml;

	/**
	 * @var int
	 */
	protected $iSensitivity;

	/**
	 * @var int
	 */
	protected $iPriority;

	/**
	 * @var string
	 */
	protected $sReadingConfirmation;

	/**
	 * @var bool
	 */
	protected $bSafety;

	/**
	 * @var CApiMailAttachmentCollection
	 */
	protected $oAttachments;

	/**
	 * @var array
	 */
	private $aDraftInfo;

	/**
	 * @var array
	 */
	private $aExtend;

	/**
	 * @return void
	 */
	protected function __construct()
	{
		$this->Clear();
	}

	/**
	 * @return CApiMailMessage
	 */
	public function Clear()
	{
		$this->sFolder = '';
		$this->iUid = 0;
		$this->sSubject = '';
		$this->sMessageId = '';
		$this->sContentType = '';
		$this->iSize = 0;
		$this->iTextSize = 0;
		$this->iInternalTimeStampInUTC = 0;
		$this->iReceivedOrDateTimeStampInUTC = 0;
		$this->aFlags = array();
		$this->aFlagsLowerCase = array();

		$this->oFrom = null;
		$this->oSender = null;
		$this->oReplyTo = null;
		$this->oTo = null;
		$this->oCc = null;
		$this->oBcc = null;

		$this->sInReplyTo = '';
		$this->sReferences = '';

		$this->sHeaders = '';
		$this->sTextPartID = '';
		$this->sPlain = '';
		$this->sHtml = '';

		$this->iSensitivity = \MailSo\Mime\Enumerations\Sensitivity::NOTHING;
		$this->iPriority = \MailSo\Mime\Enumerations\MessagePriority::NORMAL;
		$this->bSafety = false;
		$this->sReadingConfirmation = '';

		$this->oAttachments = null;
		$this->aDraftInfo = null;
		$this->aExtend = null;

		return $this;
	}

	/**
	 * @return CApiMailMessage
	 */
	public static function NewInstance()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function Headers()
	{
		return $this->sHeaders;
	}

	/**
	 * @param string $mValue
	 * @param mixed $sName
	 *
	 * @return CApiMailMessage
	 */
	public function AddExtend($sName, $mValue)
	{
		if (!is_array($this->aExtend))
		{
			$this->aExtend = array();
		}

		$this->aExtend[$sName] = $mValue;
		
		return $this;
	}

	/**
	 * @param string $mValue
	 *
	 * @return mixed
	 */
	public function GetExtend($sName)
	{
		return isset($this->aExtend[$sName]) ? $this->aExtend[$sName] : null;
	}

	/**
	 * @return string
	 */
	public function Plain()
	{
		return $this->sPlain;
	}

	/**
	 * @return string
	 */
	public function Html()
	{
		return $this->sHtml;
	}

	/**
	 * @return string
	 */
	public function Folder()
	{
		return $this->sFolder;
	}

	/**
	 * @return int
	 */
	public function Uid()
	{
		return $this->iUid;
	}

	/**
	 * @return string
	 */
	public function MessageId()
	{
		return $this->sMessageId;
	}

	/**
	 * @return string
	 */
	public function Subject()
	{
		return $this->sSubject;
	}

	/**
	 * @return string
	 */
	public function ContentType()
	{
		return $this->sContentType;
	}

	/**
	 * @return int
	 */
	public function Size()
	{
		return $this->iSize;
	}

	/**
	 * @return int
	 */
	public function TextSize()
	{
		return $this->iTextSize;
	}

	/**
	 * @return int
	 */
	public function InternalTimeStampInUTC()
	{
		return $this->iInternalTimeStampInUTC;
	}

	/**
	 * @return int
	 */
	public function ReceivedOrDateTimeStampInUTC()
	{
		return $this->iReceivedOrDateTimeStampInUTC;
	}

	/**
	 * @return array
	 */
	public function Flags()
	{
		return $this->aFlags;
	}

	/**
	 * @return array
	 */
	public function FlagsLowerCase()
	{
		return $this->aFlagsLowerCase;
	}

	/**
	 * @return \MailSo\Mime\EmailCollection
	 */
	public function From()
	{
		return $this->oFrom;
	}

	/**
	 * @return \MailSo\Mime\EmailCollection
	 */
	public function Sender()
	{
		return $this->oSender;
	}

	/**
	 * @return \MailSo\Mime\EmailCollection
	 */
	public function To()
	{
		return $this->oTo;
	}

	/**
	 * @return \MailSo\Mime\EmailCollection
	 */
	public function Cc()
	{
		return $this->oCc;
	}

	/**
	 * @return \MailSo\Mime\EmailCollection
	 */
	public function Bcc()
	{
		return $this->oBcc;
	}

	/**
	 * @return string
	 */
	public function InReplyTo()
	{
		return $this->sInReplyTo;
	}

	/**
	 * @return string
	 */
	public function References()
	{
		return $this->sReferences;
	}

	/**
	 * @return string
	 */
	public function TextPartID()
	{
		return $this->sTextPartID;
	}

	/**
	 * @return int
	 */
	public function Sensitivity()
	{
		return $this->iSensitivity;
	}

	/**
	 * @return int
	 */
	public function Priority()
	{
		return $this->iPriority;
	}

	/**
	 * @return bool
	 */
	public function Safety()
	{
		return $this->bSafety;
	}

	/**
	 * @return string
	 */
	public function ReadingConfirmation()
	{
		return $this->sReadingConfirmation;
	}

	/**
	 * @param bool $bSafety
	 * @return void
	 */
	public function SetSafety($bSafety)
	{
		$this->bSafety = $bSafety;
	}

	/**
	 * @return CApiMailAttachmentCollection
	 */
	public function Attachments()
	{
		return $this->oAttachments;
	}

	/**
	 * @return array | null
	 */
	public function DraftInfo()
	{
		return $this->aDraftInfo;
	}

	/**
	 * @param string $sRawFolderFullName
	 * @param \MailSo\Imap\FetchResponse $oFetchResponse
	 * @param \MailSo\Imap\BodyStructure $oBodyStructure = null
	 *
	 * @return CApiMailMessage
	 */
	public static function NewFetchResponseInstance($sRawFolderFullName, $oFetchResponse, $oBodyStructure = null, $sRfc822SubMimeIndex = '')
	{
		return self::NewInstance()->InitByFetchResponse($sRawFolderFullName, $oFetchResponse, $oBodyStructure, $sRfc822SubMimeIndex);
	}

	/**
	 * @param string $sRawFolderFullName
	 * @param \MailSo\Imap\FetchResponse $oFetchResponse
	 * @param \MailSo\Imap\BodyStructure $oBodyStructure = null
	 *
	 * @return CApiMailMessage
	 */
	public function InitByFetchResponse($sRawFolderFullName, $oFetchResponse, $oBodyStructure = null, $sRfc822SubMimeIndex = '')
	{
		if (!$oBodyStructure)
		{
			$oBodyStructure = $oFetchResponse->GetFetchBodyStructure();
		}

		$oTextPart = $oBodyStructure ? $oBodyStructure->SearchHtmlOrPlainPart() : null;

		$aICalPart = $oBodyStructure ? $oBodyStructure->SearchByContentType('text/calendar') : null;
		$oICalPart = is_array($aICalPart) && 0 < count($aICalPart) ? $aICalPart[0] : null;

		$aVCardPart = $oBodyStructure ? $oBodyStructure->SearchByContentType('text/vcard') : null;
		$aVCardPart = $aVCardPart ? $aVCardPart : ($oBodyStructure ? $oBodyStructure->SearchByContentType('text/x-vcard') : null);
		$oVCardPart = is_array($aVCardPart) && 0 < count($aVCardPart) ? $aVCardPart[0] : null;

		$sUid = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::UID);
		$sSize = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::RFC822_SIZE);
		$sInternalDate = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::INTERNALDATE);
		$aFlags = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::FLAGS);

		$this->sFolder = $sRawFolderFullName;
		$this->iUid = is_numeric($sUid) ? (int) $sUid : 0;
		$this->iSize = is_numeric($sSize) ? (int) $sSize : 0;
		$this->iTextSize = 0;
		$this->aFlags = is_array($aFlags) ? $aFlags : array();
		$this->aFlagsLowerCase = array_map('strtolower', $this->aFlags);

		$this->iInternalTimeStampInUTC =
			\MailSo\Base\DateTimeHelper::ParseInternalDateString($sInternalDate);

		if ($oICalPart)
		{
			$sICal = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::BODY.'['.$oICalPart->PartID().']');
			if (!empty($sICal))
			{
				$sICal = \MailSo\Base\Utils::DecodeEncodingValue($sICal, $oICalPart->MailEncodingName());
				$sICal = \MailSo\Base\Utils::ConvertEncoding($sICal, $oICalPart->Charset(), \MailSo\Base\Enumerations\Charset::UTF_8);

				if (!empty($sICal) && false !== strpos($sICal, 'BEGIN:VCALENDAR'))
				{
					$sICal = preg_replace('/(.*)(BEGIN[:]VCALENDAR(.+)END[:]VCALENDAR)(.*)/ms', '$2', $sICal);
				}
				else
				{
					$sICal = '';
				}

				if (!empty($sICal))
				{
					$this->AddExtend('ICAL_RAW', $sICal);
				}
			}
		}

		if ($oVCardPart)
		{
			$sVCard = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::BODY.'['.$oVCardPart->PartID().']');
			if (!empty($sVCard))
			{
				$sVCard = \MailSo\Base\Utils::DecodeEncodingValue($sVCard, $oVCardPart->MailEncodingName());
				$sVCard = \MailSo\Base\Utils::ConvertEncoding($sVCard, $oVCardPart->Charset(), \MailSo\Base\Enumerations\Charset::UTF_8);

				if (!empty($sVCard) && false !== strpos($sVCard, 'BEGIN:VCARD'))
				{
					$sVCard = preg_replace('/(.*)(BEGIN\:VCARD(.+)END\:VCARD)(.*)/ms', '$2', $sVCard);
				}
				else
				{
					$sVCard = '';
				}

				if (!empty($sVCard))
				{
					$this->AddExtend('VCARD_RAW', $sVCard);
				}
			}
		}

		$sCharset = $oTextPart ? $oTextPart->Charset() : '';

		$this->sHeaders = trim($oFetchResponse->GetHeaderFieldsValue($sRfc822SubMimeIndex));
		if (!empty($this->sHeaders))
		{
			$oHeaders = \MailSo\Mime\HeaderCollection::NewInstance()->Parse($this->sHeaders);

			$sContentTypeCharset = $oHeaders->ParameterValue(
				\MailSo\Mime\Enumerations\Header::CONTENT_TYPE,
				\MailSo\Mime\Enumerations\Parameter::CHARSET
			);

			if (!empty($sContentTypeCharset))
			{
				$sCharset = $sContentTypeCharset;
			}

			if (!empty($sCharset))
			{
				$oHeaders->SetParentCharset($sCharset);
			}

			$this->sSubject = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::SUBJECT);
			$this->sMessageId = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::MESSAGE_ID);
			$this->sContentType = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::CONTENT_TYPE);

			$aReceived = $oHeaders->ValuesByName(\MailSo\Mime\Enumerations\Header::RECEIVED);
			$sReceived = !empty($aReceived[0]) ? trim($aReceived[0]) : '';

			$sDate = '';
			if (!empty($sReceived))
			{
				$aParts = explode(';', $sReceived);
				if (0 < count($aParts))
				{
					$aParts = array_reverse($aParts);
					foreach ($aParts as $sReceiveLine)
					{
						$sReceiveLine = trim($sReceiveLine);
						if (preg_match('/[\d]{4} [\d]{2}:[\d]{2}:[\d]{2} /', $sReceiveLine))
						{
							$sDate = $sReceiveLine;
							break;
						}
					}
				}
			}

			if (empty($sDate))
			{
				$sDate = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::DATE);
			}

			if (!empty($sDate))
			{
				$this->iReceivedOrDateTimeStampInUTC =
					\MailSo\Base\DateTimeHelper::ParseRFC2822DateString($sDate);
			}

			$this->oFrom = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::FROM_);
			$this->oTo = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::TO_);
			$this->oCc = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::CC);
			$this->oBcc = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::BCC);
			$this->oSender = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::SENDER);
			$this->oReplyTo = $oHeaders->GetAsEmailCollection(\MailSo\Mime\Enumerations\Header::REPLY_TO);

			$this->sInReplyTo = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::IN_REPLY_TO);
			$this->sReferences = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::REFERENCES);

			// Sensitivity
			$this->iSensitivity = \MailSo\Mime\Enumerations\Sensitivity::NOTHING;
			$sSensitivity = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::SENSITIVITY);
			switch (strtolower($sSensitivity))
			{
				case 'personal':
					$this->iSensitivity = \MailSo\Mime\Enumerations\Sensitivity::PERSONAL;
					break;
				case 'private':
					$this->iSensitivity = \MailSo\Mime\Enumerations\Sensitivity::PRIVATE_;
					break;
				case 'company-confidential':
					$this->iSensitivity = \MailSo\Mime\Enumerations\Sensitivity::CONFIDENTIAL;
					break;
			}

			// Priority
			$this->iPriority = \MailSo\Mime\Enumerations\MessagePriority::NORMAL;
			$sPriority = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::X_MSMAIL_PRIORITY);
			if (0 === strlen($sPriority))
			{
				$sPriority = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::IMPORTANCE);
			}
			if (0 === strlen($sPriority))
			{
				$sPriority = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::X_PRIORITY);
			}
			if (0 < strlen($sPriority))
			{
				switch (str_replace(' ', '', strtolower($sPriority)))
				{
					case 'high':
					case '1(highest)':
					case '2(high)':
					case '1':
					case '2':
						$this->iPriority = \MailSo\Mime\Enumerations\MessagePriority::HIGH;
						break;

					case 'low':
					case '4(low)':
					case '5(lowest)':
					case '4':
					case '5':
						$this->iPriority = \MailSo\Mime\Enumerations\MessagePriority::LOW;
						break;
				}
			}

			// ReadingConfirmation
			$this->sReadingConfirmation = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::DISPOSITION_NOTIFICATION_TO);
			if (0 === strlen($this->sReadingConfirmation))
			{
				$this->sReadingConfirmation = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::X_CONFIRM_READING_TO);
			}

			$this->sReadingConfirmation = trim($this->sReadingConfirmation);

			$sDraftInfo = $oHeaders->ValueByName(\MailSo\Mime\Enumerations\Header::X_DRAFT_INFO);
			if (0 < strlen($sDraftInfo))
			{
				$sType = '';
				$sFolder = '';
				$sUid = '';

				\MailSo\Mime\ParameterCollection::NewInstance($sDraftInfo)
					->ForeachList(function ($oParameter) use (&$sType, &$sFolder, &$sUid) {

						switch (strtolower($oParameter->Name()))
						{
							case 'type':
								$sType = $oParameter->Value();
								break;
							case 'uid':
								$sUid = $oParameter->Value();
								break;
							case 'folder':
								$sFolder = base64_decode($oParameter->Value());
								break;
						}
					})
				;

				if (0 < strlen($sType) && 0 < strlen($sFolder) && 0 < strlen($sUid))
				{
					$this->aDraftInfo = array($sType, $sUid, $sFolder);
				}
			}
		}

		if ($oTextPart)
		{
			$this->sTextPartID = $oTextPart->PartID();
			$this->iTextSize = $oTextPart->EstimatedSize();

			$sText = $oFetchResponse->GetFetchValue(\MailSo\Imap\Enumerations\FetchType::BODY.'['.$oTextPart->PartID().']');
			if (!empty($sText))
			{
				$sTextCharset = $oTextPart->Charset();
				if (empty($sTextCharset))
				{
					$sTextCharset = $sCharset;
				}

				$sText = \MailSo\Base\Utils::DecodeEncodingValue($sText, $oTextPart->MailEncodingName());
				$sText = \MailSo\Base\Utils::ConvertEncoding($sText, $sTextCharset, \MailSo\Base\Enumerations\Charset::UTF_8);

				if ('text/html' === $oTextPart->ContentType())
				{
					$this->sHtml = $sText;
				}
				else
				{
					$this->sPlain = $sText;
				}
			}
		}

		if ($oBodyStructure)
		{
			$aAttachmentsParts = $oBodyStructure->SearchAttachmentsParts();
			if ($aAttachmentsParts && 0 < count($aAttachmentsParts))
			{
				$this->oAttachments = CApiMailAttachmentCollection::NewInstance();
				foreach ($aAttachmentsParts as /* @var $oAttachmentItem \MailSo\Imap\BodyStructure */ $oAttachmentItem)
				{
					$this->oAttachments->Add(
						CApiMailAttachment::NewBodyStructureInstance($this->sFolder, $this->iUid, $oAttachmentItem)
					);
				}
			}
		}

		return $this;
	}
}
