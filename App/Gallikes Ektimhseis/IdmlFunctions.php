<?php

function storyHeader(&$Content, $Id) {
	$Content =
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="11.2">
			<Story Self="Story_1_'.$Id.'" AppliedTOCStyle="n" UserText="true" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
				<StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
				<InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
	';
}

function storyFooter(&$Content) {
	$Content.=
		'	</Story>
		</idPkg:Story>
	';
}


function storyTitle(&$Content, $Title) {
	$Content =
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="11.2">
			<Story Self="Story_1_Title" AppliedTOCStyle="n" UserText="true" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
				<StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
				<InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
				<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" HyphenateLadderLimit="0" LeftIndent="0.05000000074505806" RightIndent="0.05000000074505806" FirstLineIndent="0.05000000074505806" HyphenationZone="34.04999923706055" SpaceBefore="0.04265000063553452" SpaceAfter="0.04265000063553452" DesiredWordSpacing="50" MaximumWordSpacing="50" MinimumWordSpacing="50" MaximumLetterSpacing="25" MinimumLetterSpacing="-5" KeepFirstLines="1" KeepLastLines="1" RuleAboveLineWeight="0.853" RuleAboveTint="100" RuleBelowLineWeight="0.853" RuleBelowTint="100" Justification="CenterAlign">
					<Properties>
						<TabList type="list">
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">17</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">102.05000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">127.55000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">184.25</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">RightAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">283.45001220703125</Position>
							</ListItem>
						</TabList>
						<RuleAboveColor type="object">Color/Black</RuleAboveColor>
						<RuleBelowColor type="object">Color/Black</RuleBelowColor>
					</Properties>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FillColor="Color/Paper" FontStyle="Bold" PointSize="11.942" HorizontalScale="116.06096131301291" StrokeWeight="0.9235799911215054" Capitalization="AllCaps" AppliedLanguage="$ID/English: UK" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>'.htmlspecialchars($Title).'</Content>
					</CharacterStyleRange>
				</ParagraphStyleRange>
			</Story>
		</idPkg:Story>
	';
}


function storySubtitle(&$Content, $Subtitle) {
	$Content =
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="11.2">
			<Story Self="Story_1_Subtitle" AppliedTOCStyle="n" UserText="true" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
				<StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
				<InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
				<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" HyphenateLadderLimit="0" AutoLeading="90" HyphenationZone="34.04999923706055" DesiredWordSpacing="50" MaximumWordSpacing="50" MinimumWordSpacing="50" MaximumLetterSpacing="25" MinimumLetterSpacing="-5" KeepFirstLines="1" KeepLastLines="1" RuleAboveTint="100" RuleBelowTint="100" Justification="CenterAlign">
					<Properties>
						<TabList type="list">
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">17</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">102.05000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">127.55000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">184.25</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">RightAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">283.45001220703125</Position>
							</ListItem>
						</TabList>
						<RuleAboveColor type="object">Color/Black</RuleAboveColor>
						<RuleBelowColor type="object">Color/Black</RuleBelowColor>
					</Properties>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="10" Capitalization="AllCaps" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>'.htmlspecialchars($Subtitle).'</Content>
					</CharacterStyleRange>
				</ParagraphStyleRange>
			</Story>
		</idPkg:Story>
	';
}


function storyRange(&$Content, $Range) {
	$Content =
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="11.2">
			<Story Self="Story_1_Range" AppliedTOCStyle="n" UserText="true" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
				<StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
				<InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
				<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" HyphenateLadderLimit="0" AutoLeading="90" HyphenationZone="34.04999923706055" DesiredWordSpacing="50" MaximumWordSpacing="50" MinimumWordSpacing="50" MaximumLetterSpacing="25" MinimumLetterSpacing="-5" KeepFirstLines="1" KeepLastLines="1" RuleAboveTint="100" RuleBelowTint="100" Justification="CenterAlign">
					<Properties>
						<TabList type="list">
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">17</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">102.05000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">127.55000305175781</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">184.25</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">RightAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">283.45001220703125</Position>
							</ListItem>
						</TabList>
						<RuleAboveColor type="object">Color/Black</RuleAboveColor>
						<RuleBelowColor type="object">Color/Black</RuleBelowColor>
					</Properties>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FillColor="Color/Paper" FontStyle="Bold" PointSize="14" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>'.htmlspecialchars($Range).' μ.</Content>
					</CharacterStyleRange>
				</ParagraphStyleRange>
			</Story>
		</idPkg:Story>
	';
}


function storyMainBody(&$Content, $TopRate, $TopDate, $Races, $Wins, $Places) {
	$Content.=
		'<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/NormalParagraphStyle" LeftIndent="4.251968503937008" HyphenationZone="38.772" SpaceAfter="3.0160629921259847" RuleAboveLineWeight="1.077" RuleAboveOffset="12.755905511811024" RuleBelowLineWeight="1.077" RuleBelowOffset="2.834645669291339" RuleBelow="true">
			<Properties>
				<TabList type="list">
					<ListItem type="record">
						<Alignment type="enumeration">LeftAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">20</Position>
					</ListItem>
					<ListItem type="record">
						<Alignment type="enumeration">LeftAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">135</Position>
					</ListItem>
					<ListItem type="record">
						<Alignment type="enumeration">LeftAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">162.00000000000003</Position>
					</ListItem>
					<ListItem type="record">
						<Alignment type="enumeration">LeftAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">248.00031496062996</Position>
					</ListItem>
					<ListItem type="record">
						<Alignment type="enumeration">RightAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">350</Position>
					</ListItem>
				</TabList>
			</Properties>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="12.5" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="9.693" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="19.386" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="10" StrokeWeight="1.077" BaselineShift="-3" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="7.539" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.539" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>		</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="6.8" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>Top rate: </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.8" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.(!$TopRate ? '-' : htmlspecialchars($TopRate).' ('.htmlspecialchars($TopDate).')').'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.824" HorizontalScale="105.50996483001174" StrokeWeight="0.9946956504378612" AppliedLanguage="$ID/Greek" MiterLimit="3.978782601751445" RubyFontSize="-0.918681" RubyXScale="117.23329425556858" KentenFontSize="-0.918681" KentenXScale="117.23329425556858">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> </Content>
			</CharacterStyleRange>
			'.(!$Races["All"] ? '' :
				'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.5" HorizontalScale="105.50996483001174" StrokeWeight="0.9946956504378612" AppliedLanguage="$ID/Greek" MiterLimit="3.978782601751445" RubyFontSize="-0.918681" RubyXScale="117.23329425556858" KentenFontSize="-0.918681" KentenXScale="117.23329425556858">
					<Properties>
						<Leading type="unit">12</Leading>
						<AppliedFont type="string">UB-Helvetica</AppliedFont>
					</Properties>
					<Content>	</Content>
				</CharacterStyleRange>
				<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
					<Properties>
						<Leading type="unit">12</Leading>
						<AppliedFont type="string">UB-Helvetica</AppliedFont>
					</Properties>
					<Content>Συμμ.-νίκ.-πλ.: </Content>
				</CharacterStyleRange>
				<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
					<Properties>
						<Leading type="unit">12</Leading>
						<AppliedFont type="string">UB-Helvetica</AppliedFont>
					</Properties>
					<Content>['.htmlspecialchars($Races["All"]).'-'.htmlspecialchars($Wins["All"]).'-'.htmlspecialchars($Places["All"]).']</Content>
				</CharacterStyleRange>
				'.(!$Races["Track"] && !$Races["Range"] ? '' :
					'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>    Σε Ιππόδρ. </Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>('.htmlspecialchars($Races["Track"]).'-'.htmlspecialchars($Wins["Track"]).'-'.htmlspecialchars($Places["Track"]).')</Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>, Απόστ. </Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>('.htmlspecialchars($Races["Range"]).'-'.htmlspecialchars($Wins["Range"]).'-'.htmlspecialchars($Places["Range"]).')</Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>, Ιππόδρ.-Απόστ. </Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="7.5" HorizontalScale="109.02696365767879" StrokeWeight="0.9235799911215054" MiterLimit="3.6943199644860214" RubyFontSize="-0.853" RubyXScale="117.23329425556858" KentenFontSize="-0.853" KentenXScale="117.23329425556858">
						<Properties>
							<Leading type="unit">12</Leading>
							<AppliedFont type="string">UB-Helvetica</AppliedFont>
						</Properties>
						<Content>('.htmlspecialchars($Races["Track_Range"]).'-'.htmlspecialchars($Wins["Track_Range"]).'-'.htmlspecialchars($Places["Track_Range"]).')</Content>
					</CharacterStyleRange>
				')
			).
			'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.462" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">'.($Races["All"] ? '12' : '3').'</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Br />
			</CharacterStyleRange>
		</ParagraphStyleRange>
	';
}

?>