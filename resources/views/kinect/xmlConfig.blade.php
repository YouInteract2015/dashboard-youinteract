<?xml version="1.0" encoding="utf-8"?>
<KinectApp>
	<Themes>
		<Entry>
			<Theme_id>{{ $template->id }}</Theme_id>
			<Theme_name>{{ $template->title }}</Theme_name>
			<Active>Active</Active>
			<Theme_font>N/A</Theme_font>
		</Entry>
	</Themes>
	<Important_dates>
	</Important_dates>
	<Apps>
		@foreach($items as $item)
		<Entry>
			<Apps_name>{{ $item->title }}</Apps_name>
			<App_id>{{ $item->id }}</App_id>
			<App_desc>{{ $item->description }}</App_desc>
			<Times_played>0</Times_played>
			<Highscore>0</Highscore>
			<Active>True</Active>
			<Ordernumber>0</Ordernumber>
			<Dll>{{ $item->title }}</Dll>
		</Entry>
		@endforeach
	</Apps>
</KinectApp>