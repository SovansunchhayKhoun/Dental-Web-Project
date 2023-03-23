<?php
	
	namespace Database\Seeders;
	
	use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;
	
	class OurDoctorSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run ()
		{
			DB ::table ( 'our_doctors' ) -> insert ( [
				'title' => 'Dr. ' ,
				'name' => 'Sunchhay Khoun' ,
				'email' => 'sunchhay@cadt.kh' ,
				'specialist' => 'Backend Development' ,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie elit a imperdiet porttitor. In non ex ex. Nam convallis, nunc quis pulvinar feugiat, dolor augue lobortis magna, quis varius velit sem et felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.' ,
				'work_experience' => 'Nothing'
			] );
			
			DB ::table ( 'our_doctors' ) -> insert ( [
				'title' => 'Dr. ' ,
				'name' => 'Rethtihpong Em' ,
				'email' => 'rethtihpong@cadt.kh' ,
				'specialist' => 'Backend Development' ,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie elit a imperdiet porttitor. In non ex ex. Nam convallis, nunc quis pulvinar feugiat, dolor augue lobortis magna, quis varius velit sem et felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.' ,
				'work_experience' => 'Nothing'
			] );
			
			DB ::table ( 'our_doctors' ) -> insert ( [
				'title' => 'Dr. ' ,
				'name' => 'Rattanakpanha Kong' ,
				'email' => 'rattanakpanha@cadt.kh' ,
				'specialist' => 'Frontend Development' ,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie elit a imperdiet porttitor. In non ex ex. Nam convallis, nunc quis pulvinar feugiat, dolor augue lobortis magna, quis varius velit sem et felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.' ,
				'work_experience' => 'Nothing'
			] );
			
			DB ::table ( 'our_doctors' ) -> insert ( [
				'title' => 'Dr. ' ,
				'name' => 'Liza John' ,
				'email' => 'liza@cadt.kh' ,
				'specialist' => 'UX/UI Design' ,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie elit a imperdiet porttitor. In non ex ex. Nam convallis, nunc quis pulvinar feugiat, dolor augue lobortis magna, quis varius velit sem et felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.' ,
				'work_experience' => 'Nothing'
			] );
			
			DB ::table ( 'our_doctors' ) -> insert ( [
				'title' => 'Dr. ' ,
				'name' => 'Liza Chan' ,
				'email' => 'lizaChan@cadt.kh' ,
				'specialist' => 'UX/UI Design' ,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie elit a imperdiet porttitor. In non ex ex. Nam convallis, nunc quis pulvinar feugiat, dolor augue lobortis magna, quis varius velit sem et felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.' ,
				'work_experience' => 'Nothing'
			] );
		}
	}
