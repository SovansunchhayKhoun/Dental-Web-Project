<?php

	namespace Database\Factories;

	use Illuminate\Database\Eloquent\Factories\Factory;

	/**
	 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
	 */
	class AppointmentFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 *
		 * @return array<string, mixed>
		 */
		public function definition ()
		{
			return [
				'firstName' => fake () -> firstName () ,
				'lastName' => fake () -> lastName () ,
				'fullName' => fake()->name(),
				'phoneNum' => fake () -> phoneNumber () ,
				'email' => fake () -> email () ,
				'birthday' => fake () -> date () ,
				'appointmentDate' => fake () -> date () ,
				'message' => fake () -> text ()
			];
		}
	}
