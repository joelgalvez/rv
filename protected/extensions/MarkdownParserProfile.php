<?php
#
# My Markdown Parser Class for profile
#
  // @version $Id: MarkdownParserProfile.php 18 2009-05-07 01:42:32Z mocapapa@g.pugpug.org $
class MarkdownParserProfile extends CMarkdownParser {

	public function doImages($text) {
	#
	# Turn Markdown image shortcuts into <img> tags.
	#
		#
		# First, handle reference-style labeled images: ![alt text][id]
		#
		$text = preg_replace_callback('{
			(				# wrap whole match in $1
			  !\[
				('.$this->nested_brackets_re.')		# alt text = $2
			  \]

			  [ ]?				# one optional space
			  (?:\n[ ]*)?		# one optional newline followed by spaces

			  \[
				(.*?)		# id = $3
			  \]

			)
			}xs',
			array(&$this, '_doImages_reference_callback'), $text);

		#
		# Next, handle inline images:  ![alt text](url "optional title")
		# Don't forget: encode * and _
		#
		$text = preg_replace_callback('{
			(				# wrap whole match in $1
			  \*\[
				('.$this->nested_brackets_re.')		# alt text = $2
			  \]
			  \s?			# One optional whitespace character
			  \(			# literal paren
				[ ]*
				(?:
					<(\S*)>	# src url = $3
				|
					('.$this->nested_url_parenthesis_re.')	# src url = $4
				)
				[ ]*
				(			# $5
				  ([\'"])	# quote char = $6
				  (.*?)		# title = $7
				  \6		# matching quote
				  [ ]*
				)?			# title is optional
			  \)
			)
			}xs',
			array(&$this, '_doImages_inline_highslide_callback'), $text);

		#
		# Next, handle inline images:  ![alt text](url "optional title")
		# Don't forget: encode * and _
		#
		$text = preg_replace_callback('{
			(				# wrap whole match in $1
			  !\[
				('.$this->nested_brackets_re.')		# alt text = $2
			  \]
			  \s?			# One optional whitespace character
			  \(			# literal paren
				[ ]*
				(?:
					<(\S*)>	# src url = $3
				|
					('.$this->nested_url_parenthesis_re.')	# src url = $4
				)
				[ ]*
				(			# $5
				  ([\'"])	# quote char = $6
				  (.*?)		# title = $7
				  \6		# matching quote
				  [ ]*
				)?			# title is optional
			  \)
			)
			}xs',
			array(&$this, '_doImages_inline_callback'), $text);

		return $text;
        }

        public function _doImages_inline_highslide_callback($matches) {
                $whole_match    = $matches[1];
                $alt_text               = $matches[2];
                $url                    = $matches[3] == '' ? $matches[4] : $matches[3];
                $title                  =& $matches[7];

                $alt_text = $this->encodeAttribute($alt_text);
                $url = $this->encodeAttribute($url);

                $file = Yii::app()->params['imageHomeAbs'].$url;
                if (file_exists($file))
                    $size=getimagesize($file);
                else
                    $size=array(100, 100);
		$url = Yii::app()->baseUrl.'/'.Yii::app()->params['imageHome'].$url;

                $bb = Yii::app()->params['profileImageBoundingbox'];
		if ($size[0] > $bb && $size[1] <= $bb)
		  $whtext = 'width';
		else if ($size[0] <= $bb && $size[1] > $bb)
		  $whtext = 'height';
		else if ($size[0] > $bb && $size[1] > $bb)
		  if (1.0 <= $size[1]/$size[0])
		    $whtext = 'height';
		  else
		    $whtext = 'width';

                $result = "<img src=\"$url\" alt=\"$alt_text\" $whtext =$bb ";

                if (isset($title)) {
                        $title = $this->encodeAttribute($title);
                        $result .=  " title=\"$title\""; # $title already quoted
                }
                $result .= $this->empty_element_suffix;

                return $this->hashPart($result);
        }

}
