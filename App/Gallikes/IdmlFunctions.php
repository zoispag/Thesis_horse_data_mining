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


function storySubtitle(&$Content, $Subtitle, $MoneySymbol, $Money/*, $Age, $Class, $Type*/) {
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
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="11" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Br />
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="9" HorizontalScale="95" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">Arial</AppliedFont>
						</Properties>
						<Content>'.htmlspecialchars($MoneySymbol).'</Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="9" HorizontalScale="95" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>  '.htmlspecialchars($Money).'</Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="9" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">10</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>  - </Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8" AppliedLanguage="$ID/English: UK">
						<Properties>
							<Leading type="unit">8</Leading>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>Ίπποι ετών &amp; άνω, Κλάση, Επίπεδη, Γκαζόν'/*.'Ίπποι '.htmlspecialchars($Age).' ετών'.(!$Class ? "" : ', Κλάση '.htmlspecialchars($Class)).(!$Type ? "" : ', '.htmlspecialchars($Type))*/.'</Content>
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


function storyTime(&$Content, $Time) {
	$Content =
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="11.2">
			<Story Self="Story_1_Time" AppliedTOCStyle="n" UserText="true" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
				<StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
				<InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
				<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" HyphenateLadderLimit="0" LeftIndent="0.05248000078201294" RightIndent="0.05248000078201294" FirstLineIndent="0.05248000078201294" HyphenationZone="35.73887919921875" SpaceBefore="0.05248000078201294" SpaceAfter="0.05248000078201294" DesiredWordSpacing="50" MaximumWordSpacing="50" MinimumWordSpacing="50" MaximumLetterSpacing="25" MinimumLetterSpacing="-5" KeepFirstLines="1" KeepLastLines="1" RuleAboveLineWeight="1.0495999999999999" RuleAboveTint="100" RuleBelowLineWeight="1.0495999999999999" RuleBelowTint="100" Justification="LeftJustified">
					<Properties>
						<TabList type="list">
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">17.8432</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">107.111683203125</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">133.876483203125</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">193.38879999999997</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">RightAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">297.5091328125</Position>
							</ListItem>
						</TabList>
						<RuleAboveColor type="object">Color/Black</RuleAboveColor>
						<RuleBelowColor type="object">Color/Black</RuleBelowColor>
					</Properties>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FillColor="Color/Paper" FontStyle="Bold" PointSize="8.396799999999999" StrokeWeight="1.0495999999999999" AppliedLanguage="$ID/English: UK" MiterLimit="4.1983999999999995" RubyFontSize="-1.0495999999999999" KentenFontSize="-1.0495999999999999">
						<Properties>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content> </Content>
					</CharacterStyleRange>
					<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8.396799999999999" StrokeWeight="1.0495999999999999" AppliedLanguage="$ID/English: UK" MiterLimit="4.1983999999999995" RubyFontSize="-1.0495999999999999" KentenFontSize="-1.0495999999999999">
						<Properties>
							<AppliedFont type="string">UB-Souvenir</AppliedFont>
						</Properties>
						<Content>'.htmlspecialchars($Time).'</Content>
					</CharacterStyleRange>
				</ParagraphStyleRange>
			</Story>
		</idPkg:Story>
	';
}


function storyMainBody(&$Content, $IsDebut, $Name, $Weight, $Jockey, $Owner, $Number, $Color, $Sex, $Age, $Que, $Trainer, $OwnerColors, $Start, $Father, $Mother, $TopRate, $TopDate, $MoneySymbol, $Money, $Races, $Wins, $Places, $IsTrot) {
	$Content.=
		'<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/NormalParagraphStyle" LeftIndent="'.($Number < 10 ? '4.251968503937008' :  '0.8503937007874015').'" HyphenationZone="38.772" SpaceAfter="3.0160629921259847" RuleAboveLineWeight="1.077" RuleAboveOffset="12.755905511811024" RuleBelowLineWeight="1.077" RuleBelowOffset="2.834645669291339" RuleBelow="true">
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
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="11.847" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="12.5" HorizontalScale="90" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Name).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="11.847" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="10.77" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Weight).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="10.77" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="10" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Jockey).'	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="9.693" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">14.5</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Owner).' </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="19.386"'.($Number < 10 ? '' : ' HorizontalScale="75"').' StrokeWeight="1.077" BaselineShift="-5" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Number).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="19.386" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7.5" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Color).''.htmlspecialchars($Sex).''.htmlspecialchars($Age).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.462" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>  </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="BoldItalic" PointSize="8" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>('.htmlspecialchars($Que).')</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="7.539" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>		</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="8.5" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Trainer).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="7.539" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>	'.htmlspecialchars($OwnerColors).'	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" StrokeWeight="1.077" BaselineShift="-3" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Start).'</Content>
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
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" PointSize="8.5" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($Father).' - '.htmlspecialchars($Mother).'</Content>
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
				<Content>'.($IsDebut || $TopRate == "NO" ? '' : 'Top rate: ').'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.8" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>'.($IsDebut || $TopRate == "NO" ? '' : (!$TopRate ? '-' : htmlspecialchars($TopRate).' ('.htmlspecialchars($TopDate).')')).'	</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.462" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content>(</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">Arial</AppliedFont>
				</Properties>
				<Content>'.htmlspecialchars($MoneySymbol).'</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="7" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> '.htmlspecialchars($Money).')</Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.824" HorizontalScale="105.50996483001174" StrokeWeight="0.9946956504378612" AppliedLanguage="$ID/Greek" MiterLimit="3.978782601751445" RubyFontSize="-0.918681" RubyXScale="117.23329425556858" KentenFontSize="-0.918681" KentenXScale="117.23329425556858">
				<Properties>
					<Leading type="unit">10</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Content> </Content>
			</CharacterStyleRange>
			'.($IsDebut || !$IsTrot ? '' :
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
				'.(!$Races["Course"] && !$Races["Dist"] ? '' :
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
						<Content>('.htmlspecialchars($Races["Course"]).'-'.htmlspecialchars($Wins["Course"]).'-'.htmlspecialchars($Places["Course"]).')</Content>
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
						<Content>('.htmlspecialchars($Races["Dist"]).'-'.htmlspecialchars($Wins["Dist"]).'-'.htmlspecialchars($Places["Dist"]).')</Content>
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
						<Content>('.htmlspecialchars($Races["CourseDist"]).'-'.htmlspecialchars($Wins["CourseDist"]).'-'.htmlspecialchars($Places["CourseDist"]).')</Content>
					</CharacterStyleRange>
				')
			).
			'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Italic" PointSize="6.462" StrokeWeight="1.077" AppliedLanguage="$ID/Greek" MiterLimit="4.308" RubyFontSize="-1.077" KentenFontSize="-1.077">
				<Properties>
					<Leading type="unit">'.(!$IsDebut ? '12' : '3').'</Leading>
					<AppliedFont type="string">UB-Helvetica</AppliedFont>
				</Properties>
				<Br />
			</CharacterStyleRange>
		</ParagraphStyleRange>
	';
}


function storyHistoryBody(&$Content, $Number, $Date, $Rank, $Runners, $Weight, $Jockey, $Start, $Track, $Range, $Type, $Class, $Terrain, $Money, $Winner, $Time, $Lengths, $Rate, $Perform) {
	$Content.=
		($Number > 1 ? '' :
			'<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" RuleAboveOffset="8.220471" RuleBelowLineWeight="1.077" RuleBelowOffset="2.834645669291339" RuleBelow="true">
				<Properties>
					<TabList type="list">
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">14.173228346456694</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">44.98582677165354</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">66.98267716535433</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">132.00944881889765</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">169.0015748031496</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">192.98267716535435</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">209.99055118110238</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">223.99370078740156</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">241.0015748031496</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">294.0094488188977</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">325.98425196850394</Position>
						</ListItem>
						'.($Rate == "NO" ?
							'<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">360</Position>
							</ListItem>
						':
							'<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">354.98267716535435</Position>
							</ListItem>
							<ListItem type="record">
								<Alignment type="enumeration">LeftAlign</Alignment>
								<AlignmentCharacter type="string">.</AlignmentCharacter>
								<Leader type="string"></Leader>
								<Position type="unit">370.00629921259844</Position>
							</ListItem>
						').
					'</TabList>
				</Properties>
				<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
					<Properties>
						<Leading type="unit">6.5</Leading>
						<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
					</Properties>
					<Content>	</Content>
				</CharacterStyleRange>
		').
		'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
			<Properties>
				<Leading type="unit">0</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content> </Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Date).'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Rank).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>/'.htmlspecialchars($Runners).'	'.(!$Weight ? '' : '('.htmlspecialchars($Weight).')').''.htmlspecialchars($Jockey).''.(!$Start ? '' : '('.htmlspecialchars($Start).')').'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Track).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Range).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content> '.htmlspecialchars($Type).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Class).'	'.htmlspecialchars($Terrain).'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Money).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Winner).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Time).'	'.htmlspecialchars($Lengths).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.($Rate == "NO" ? '' : htmlspecialchars($Rate).'	').''.htmlspecialchars($Perform).'</Content>
		</CharacterStyleRange>
	';
}

function storyHistoryDebut(&$Content) {
	$Content.=
		'<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" RuleAboveOffset="8.220471" RuleBelowLineWeight="1.077" RuleBelowOffset="2.834645669291339" RuleBelow="true">
			<Properties>
				<TabList type="list">
					<ListItem type="record">
						<Alignment type="enumeration">LeftAlign</Alignment>
						<AlignmentCharacter type="string">.</AlignmentCharacter>
						<Leader type="string"></Leader>
						<Position type="unit">14.173228346456694</Position>
					</ListItem>
				</TabList>
			</Properties>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
				<Properties>
					<Leading type="unit">6.5</Leading>
					<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
				</Properties>
				<Content>	 </Content>
			</CharacterStyleRange>
			<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">7</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	Κάνει ντεμπούτο</Content>
		</CharacterStyleRange>
	';
}

function storyHistoryLine(&$Content) {
	$Content.=
		'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
			<Properties>
				<Leading type="unit">0</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content> </Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">9</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	</Content>
		</CharacterStyleRange>
	';
}

function storyHistoryNewLine(&$Content) {
	$Content.=
		'	<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
				<Properties>
					<Leading type="unit">9</Leading>
					<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
				</Properties>
				<Br />
			</CharacterStyleRange>
		</ParagraphStyleRange>
	';
}


function storyHistoryBody_Trot(&$Content, $Number, $Date, $Rank, $Runners, $Jockey, $Track, $Range, $Type, $Petals, $Money, $Winner, $Time, $Lengths, $Perform) {
	$Content.=
		($Number > 1 ? '' :
			'<ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/$ID/[No paragraph style]" RuleAboveOffset="8.220471" RuleBelowLineWeight="1.077" RuleBelowOffset="2.834645669291339" RuleBelow="true">
				<Properties>
					<TabList type="list">
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">14.173228346456694</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">44.98582677165354</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">66.98267716535433</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">132.00944881889765</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">169.0015748031496</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">202.67716535433073</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">223.99370078740156</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">241.0015748031496</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">294.0094488188977</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">325.98425196850394</Position>
						</ListItem>
						<ListItem type="record">
							<Alignment type="enumeration">LeftAlign</Alignment>
							<AlignmentCharacter type="string">.</AlignmentCharacter>
							<Leader type="string"></Leader>
							<Position type="unit">360</Position>
						</ListItem>
					</TabList>
				</Properties>
				<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
					<Properties>
						<Leading type="unit">6.5</Leading>
						<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
					</Properties>
					<Content>	</Content>
				</CharacterStyleRange>
		').
		'<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="0.1">
			<Properties>
				<Leading type="unit">0</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content> </Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Date).'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Rank).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>/'.htmlspecialchars($Runners).'	'.htmlspecialchars($Jockey).'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Track).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Range).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content> '.htmlspecialchars($Type).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Petals).'	</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>'.htmlspecialchars($Money).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Winner).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Bold" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Time).'	'.htmlspecialchars($Lengths).'</Content>
		</CharacterStyleRange>
		<CharacterStyleRange AppliedCharacterStyle="CharacterStyle/$ID/[No character style]" FontStyle="Normal" PointSize="8">
			<Properties>
				<Leading type="unit">'.($Number > 1 ? '9' : '7').'</Leading>
				<AppliedFont type="string">UB-HelveticaCond</AppliedFont>
			</Properties>
			<Content>	'.htmlspecialchars($Perform).'</Content>
		</CharacterStyleRange>
	';
}

?>