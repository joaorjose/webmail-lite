<?php

namespace MailSo\Base;

/**
 * @category MailSo
 * @package Base
 */
class LinkFinder
{
	/**
	 * @const
	 */
	const OPEN_LINK = '@#@link{';
	const CLOSE_LINK = '}link@#@';

	/**
	 * @var array
	 */
	private $aPrepearPlainStringUrls;

	/**
	 * @var string
	 */
	private $sText;

	/**
	 * @var mixed
	 */
	private $fLinkWrapper;

	/**
	 * @var int
	 */
	private $iHhtmlSpecialCharsFlags;

	/**
	 * @var mixed
	 */
	private $fMailWrapper;

	/**
	 * @access private
	 */
	private function __construct()
	{
		$this->iHhtmlSpecialCharsFlags = (\defined('ENT_QUOTES') && \defined('ENT_SUBSTITUTE') && \defined('ENT_HTML401'))
			? ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401 : ENT_QUOTES;

		$this->Clear();
	}

	/**
	 * @return \MailSo\Base\LinkFinder
	 */
	public static function NewInstance()
	{
		return new self();
	}

	/**
	 * @return \MailSo\Base\LinkFinder
	 */
	public function Clear()
	{
		$this->aPrepearPlainStringUrls = array();
		$this->fLinkWrapper = null;
		$this->fMailWrapper = null;
		$this->sText = '';

		return $this;
	}

	/**
	 * @param string $sText
	 *
	 * @return \MailSo\Base\LinkFinder
	 */
	public function Text($sText)
	{
		$this->sText = $sText;

		return $this;
	}

	/**
	 * @param mixed $fLinkWrapper
	 *
	 * @return \MailSo\Base\LinkFinder
	 */
	public function LinkWrapper($fLinkWrapper)
	{
		$this->fLinkWrapper = $fLinkWrapper;

		return $this;
	}

	/**
	 * @param mixed $fMailWrapper
	 *
	 * @return \MailSo\Base\LinkFinder
	 */
	public function MailWrapper($fMailWrapper)
	{
		$this->fMailWrapper = $fMailWrapper;

		return $this;
	}

	/**
	 * @param bool $bAddTargetBlank = false
	 *
	 * @return \MailSo\Base\LinkFinder
	 */
	public function UseDefaultWrappers($bAddTargetBlank = false)
	{
		$this->fLinkWrapper = function ($sLink, $bShortLink = false) use ($bAddTargetBlank) {

			if ($bShortLink && \in_array(\strtolower($sLink), array('asp.net', 'vb.net', 'mailbee.net')))
			{
				return $sLink;
			}

			$sNameLink = $sLink;
			if ($bShortLink && !\preg_match('/^[a-z]{3-5}:\/\//i', \ltrim($sLink)))
			{
				$sLink = 'http://'.\ltrim($sLink);
			}

			return '<a '.($bAddTargetBlank ? 'target="_blank" ': '').'href="'.$sLink.'">'.$sNameLink.'</a>';
		};

		$this->fMailWrapper = function ($sEmail) use ($bAddTargetBlank) {
			return '<a '.($bAddTargetBlank ? 'target="_blank" ': '').'href="mailto:'.$sEmail.'">'.$sEmail.'</a>';
		};

		return $this;
	}

	/**
	 * @param bool $bUseHtmlSpecialChars = true
	 * @param bool $bFindShortLinks = true
	 *
	 * @return string
	 */
	public function CompileText($bUseHtmlSpecialChars = true, $bFindShortLinks = true)
	{
		$sText = $this->sText;

		$this->aPrepearPlainStringUrls = array();
		if (null !== $this->fLinkWrapper && \is_callable($this->fLinkWrapper))
		{
			$sText = $this->findLinks($sText, $this->fLinkWrapper);
		}

		if (null !== $this->fMailWrapper && \is_callable($this->fMailWrapper))
		{
			$sText = $this->findMails($sText, $this->fMailWrapper);
		}

		if ($bFindShortLinks && null !== $this->fLinkWrapper && \is_callable($this->fLinkWrapper))
		{
			$sText = $this->findShortLinks($sText, $this->fLinkWrapper);
		}

		if ($bUseHtmlSpecialChars)
		{
			$sText = @\htmlspecialchars($sText, $this->iHhtmlSpecialCharsFlags, 'UTF-8');
		}

		if (0 < \count($this->aPrepearPlainStringUrls))
		{
			for ($iIndex = 0, $iLen = \count($this->aPrepearPlainStringUrls); $iIndex < $iLen; $iIndex++)
			{
				$sText = \str_replace(\MailSo\Base\LinkFinder::OPEN_LINK.$iIndex.
					\MailSo\Base\LinkFinder::CLOSE_LINK, $this->aPrepearPlainStringUrls[$iIndex], $sText);
			}

			$this->aPrepearPlainStringUrls = array();
		}

		return $sText;
	}

	/**
	 * @param string $sText
	 * @param mixed $fWrapper
	 *
	 * @return string
	 */
	private function findLinks($sText, $fWrapper)
	{
		$sPattern = '/([\W]|^)((?:https?:\/\/)|(?:svn:\/\/)|(?:git:\/\/)|(?:s?ftps?:\/\/)|(?:www\.))'.
			'((\S+?)(\\/)?)((?:&gt;)?|[^\w\=\\/;\(\)\[\]]*?)(?=<|\s|$)/im';

		$aPrepearPlainStringUrls = $this->aPrepearPlainStringUrls;
		$sText = \preg_replace_callback($sPattern, function ($aMatch) use ($fWrapper, &$aPrepearPlainStringUrls) {

			if (\is_array($aMatch) && 6 < \count($aMatch))
			{
				while (\in_array($sChar = \substr($aMatch[3], -1), array(']', ')')))
				{
					if (\substr_count($aMatch[3], ']' === $sChar ? '[': '(') - \substr_count($aMatch[3], $sChar) < 0)
					{
						$aMatch[3] = \substr($aMatch[3], 0, -1);
						$aMatch[6] = (']' === $sChar ? ']': ')').$aMatch[6];
					}
					else
					{
						break;
					}
				}

				$sLinkWithWrap = \call_user_func($fWrapper, $aMatch[2].$aMatch[3]);
				if (\is_string($sLinkWithWrap) && 0 < \strlen($sLinkWithWrap))
				{
					$aPrepearPlainStringUrls[] = \stripslashes($sLinkWithWrap);
					return $aMatch[1].
						\MailSo\Base\LinkFinder::OPEN_LINK.
						(\count($aPrepearPlainStringUrls) - 1).
						\MailSo\Base\LinkFinder::CLOSE_LINK.
						$aMatch[6];
				}

				return $aMatch[0];
			}

			return '';

		}, $sText);

		if (0 < \count($aPrepearPlainStringUrls))
		{
			$this->aPrepearPlainStringUrls = $aPrepearPlainStringUrls;
		}

		return $sText;
	}

	/**
	 * @param string $sText
	 * @param mixed $fWrapper
	 *
	 * @return string
	 */
	private function findShortLinks($sText, $fWrapper)
	{
		$sPattern = '/([a-z0-9-\.]+\.(?:com|org|net|ru))([^a-z0-9-\.])/i';

		$aPrepearPlainStringUrls = $this->aPrepearPlainStringUrls;
		$sText = \preg_replace_callback($sPattern, function ($aMatch) use ($fWrapper, &$aPrepearPlainStringUrls) {

			if (\is_array($aMatch) && 2 < \count($aMatch) && isset($aMatch[1]) && 0 < \strlen($aMatch[1]))
			{
				$sLinkWithWrap = \call_user_func_array($fWrapper, array($aMatch[1], true));
				if (\is_string($sLinkWithWrap))
				{
					$aPrepearPlainStringUrls[] = \stripslashes($sLinkWithWrap);
					return \MailSo\Base\LinkFinder::OPEN_LINK.
						(\count($aPrepearPlainStringUrls) - 1).
						\MailSo\Base\LinkFinder::CLOSE_LINK.
						$aMatch[2];
				}

				return $aMatch[0];
			}

			return '';

		}, $sText);

		if (0 < \count($aPrepearPlainStringUrls))
		{
			$this->aPrepearPlainStringUrls = $aPrepearPlainStringUrls;
		}

		return $sText;
	}

	/**
	 * @param string $sText
	 * @param mixed $fWrapper
	 *
	 * @return string
	 */
	private function findMails($sText, $fWrapper)
	{
		$sPattern = '/([\w\.!#\$%\-+.]+@[A-Za-z0-9\-]+(\.[A-Za-z0-9\-]+)+)/';

		$aPrepearPlainStringUrls = $this->aPrepearPlainStringUrls;
		$sText = \preg_replace_callback($sPattern, function ($aMatch) use ($fWrapper, &$aPrepearPlainStringUrls) {

			if (\is_array($aMatch) && isset($aMatch[1]))
			{
				$sMailWithWrap = \call_user_func($fWrapper, $aMatch[1]);
				if (\is_string($sMailWithWrap) && 0 < \strlen($sMailWithWrap))
				{
					$aPrepearPlainStringUrls[] = \stripslashes($sMailWithWrap);
					return \MailSo\Base\LinkFinder::OPEN_LINK.
						(\count($aPrepearPlainStringUrls) - 1).
						\MailSo\Base\LinkFinder::CLOSE_LINK;
				}

				return $aMatch[1];
			}

			return '';

		}, $sText);

		if (0 < \count($aPrepearPlainStringUrls))
		{
			$this->aPrepearPlainStringUrls = $aPrepearPlainStringUrls;
		}

		return $sText;
	}
}