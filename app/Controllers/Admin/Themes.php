<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\Theme_Model;

class Themes extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->theme_Model = new \App\Models\Admin\Theme_Model();
    }

    public function index()
    {
		$banner = $this->theme_Model->getAllBanners();
        $data['user'] = $banner;
        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/themes',$data);
		$template.= view('Admin/common/footer');
		$template.= view('Admin/page_scripts/themejs');
        return $template;
    }
 
	public function updateStatus()
{
    $themeId = $this->request->getPost('theme_Id');
    $newStatus = $this->request->getPost('theme_Status');
    $theme_Model = new \App\Models\Admin\Theme_Model();

    // Validate input
    if (!$themeId || !in_array($newStatus, [1, 2])) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request.'
        ]);
    }

    // Check if theme exists
    $theme = $theme_Model->getThemeStatusByid($themeId);
    if (!$theme) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Theme not found.'
        ]);
    }

    // If setting to active, deactivate all other themes
    if ($newStatus == 1) {
        $theme_Model->deactivateAllThemesExcept($themeId);
    }

    // Update current theme's status
    $update = $theme_Model->updateTheme($themeId, ['theme_Status' => $newStatus]);

    return $this->response->setJSON([
        'success' => $update,
        'message' => $update ? 'Status updated successfully.' : 'Failed to update status.',
        'new_status' => $newStatus
    ]);
}


     public function deleteBanner($theme_id) {
		if ($theme_id) {
			$modified_by = $this->session->get('zd_uid');
			$theme_Status = $this->theme_Model->deleteBannerById(3, $theme_id, $modified_by);
			if ($theme_Status) {
				echo json_encode([
					'success' => true,
					'msg' => 'Banner deleted successfully.'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'msg' => 'Failed to delete banner.'
				]);
			}
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Invalid request.'
			]);
		}
	}
	public function addbanner($theme_id = null)
	{
		if (!$this->session->get('zd_uid')) {
			return redirect()->to(base_url('admin'));
		}

		$data = [];

		if ($theme_id) {
			$banner = $this->theme_Model->getThemeByid($theme_id);

			if (!$banner) {
				return redirect()->to('admin/themes')->with('error', 'Banner not found');
			}

			// Decode section JSON data
			$banner = (array) $banner;
			$banner['theme_Section1'] = json_decode($banner['theme_Section1'], true) ?? [];
			$banner['theme_Section2'] = json_decode($banner['theme_Section2'], true) ?? [];
			$banner['theme_Section3'] = json_decode($banner['theme_Section3'], true) ?? [];

			$data['banner'] = $banner;
		}
		//print_r($data);exit;

		// Load views
		$template = view('Admin/common/header');
		$template .= view('Admin/common/leftmenu');
		$template .= view('Admin/themes_add', $data); // Pass $banner data if editing
		$template .= view('Admin/common/footer');
		$template .= view('Admin/page_scripts/themejs');
		return $template;
	}

public function save_file()
{
    $theme_Model = new Theme_Model();
    $theme_id = $this->request->getPost('theme_id');
    $mainData = $this->request->getPost();
    $files = $this->request->getFiles();
    $mainData['theme_name'] = trim($mainData['theme_name']);
    $mainData['description'] = trim($mainData['description']);

    $section1 = json_decode($mainData['theme_Section1'], true) ?? [];
    $section2 = json_decode($mainData['theme_Section2'], true) ?? [];
    $section3 = json_decode($mainData['theme_Section3'], true) ?? [];

    $errors = [];

    //  Validate theme_name and description
    if (!isset($mainData['theme_name']) || !preg_match('/^[a-zA-Z\s]+$/', $mainData['theme_name'])) {
        return $this->response->setJSON([
            'status' => 0,
            'msg' => 'Theme name must contain only letters and spaces.'
        ]);
    }

    if (!preg_match('/^[a-zA-Z0-9\s,\.\'\"\\\\;: ]+$/', $mainData['description'])) {
        return $this->response->setJSON([
            'status' => 0,
            'msg' => 'Please enter Description correctly.'
        ]);
    }

	
    foreach (['Section1' => $section1, 'Section2' => $section2, 'Section3' => $section3] as $label => $section) {
        if (empty($section)) {
            $errors[] = "$label must have at least one item.";
        }
        foreach ($section as $index => $item) {
            if (array_filter($item) === []) {
                $errors[] = "$label, item " . ($index + 1) . ": All fields are empty.";
            }
        }
    }

   if (!isset($mainData['theme_name']) || !preg_match('/^[a-zA-Z\s ]+$/', $mainData['theme_name'])) {
		return $this->response->setJSON([
			'status' => 0,
			'msg' => 'Theme name must contain only letters and spaces.'
		]);
	} 

	if (!preg_match('/^[a-zA-Z0-9\s,\.\'\"\\\\;: ]+$/', $mainData['description'])) {
		return $this->response->setJSON([
			'status' => 0,
			'msg' => 'Please enter Description Correctly.'
		]);
	}

    //  Validate Section 1
    foreach ($section1 as $i => $item) {
        if (!empty($item['link']) && !filter_var($item['link'], FILTER_VALIDATE_URL)) {
            $errors[] = "Section 1, item " . ($i + 1) . ": Link must be a valid URL.";
        }
    }

    //  Validate Section 2
    foreach ($section2 as $i => $item) {
        if (!empty($item['name']) && !preg_match('/^[a-zA-Z\s ]+$/', $item['name'])) {
            $errors[] = "Section 2, item " . ($i + 1) . ": Name must contain only letters.";
        }
        if (!empty($item['link']) && !filter_var($item['link'], FILTER_VALIDATE_URL)) {
            $errors[] = "Section 2, item " . ($i + 1) . ": Link must be a valid URL.";
        }
    }

    // Validate Section 3
    foreach ($section3 as $i => $item) {
        if (!empty($item['link']) && !filter_var($item['link'], FILTER_VALIDATE_URL)) {
            $errors[] = "Section 3, item " . ($i + 1) . ": Link must be a valid URL.";
        }
    }

    //  Validate and Upload Images
    $validateImage = function($file, $section, $index) use (&$errors) {
        if ($file->isValid() && !$file->hasMoved()) {
            $mime = $file->getMimeType();
            if (!str_starts_with($mime, 'image/')) {
                $errors[] = "$section, item " . ($index + 1) . ": Only image files are allowed.";
            }
        }
    };
    // Section 1 Images
	if (isset($files['section1_image'])) {
		foreach ($files['section1_image'] as $i => $file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $file->getRandomName();
				$file->move(ROOTPATH . 'public/uploads/themes', $newName);
				$section1[$i]['image'] = $newName;
			} else {
				// No new image uploaded, retain old
				$section1[$i]['image'] = $mainData['section1_image_old'][$i] ?? '';
			}
		}
	}


    // Section 2 Images
	if (isset($files['section2_image'])) {
		foreach ($files['section2_image'] as $i => $file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $file->getRandomName();
				$file->move(ROOTPATH . 'public/uploads/themes', $newName);
				$section2[$i]['image'] = $newName;
			} else {
				// No new image uploaded, retain old
				$section2[$i]['image'] = $mainData['section2_image_old'][$i] ?? '';
			}
		}
	}

    // Section 3 Images
	if (isset($files['section3_image'])) {
		foreach ($files['section3_image'] as $i => $file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $file->getRandomName();
				$file->move(ROOTPATH . 'public/uploads/themes', $newName);
				$section3[$i]['image'] = $newName;
			} else {
				// No new image uploaded, retain old
				$section3[$i]['image'] = $mainData['section3_image_old'][$i] ?? '';
			}
		}
	}

    // Stop if errors
    if (!empty($errors)) {
        return $this->response->setJSON([
            'status' => 0,
            'msg' => implode('/', $errors)
        ]);
    }

    //  Prepare data to save
    $data = [
        'theme_Name'        => $mainData['theme_name'],
        'theme_Description' => $mainData['description'],
        'theme_Section1'    => json_encode($section1),
        'theme_Section2'    => json_encode($section2),
        'theme_Section3'    => json_encode($section3),
        'theme_Status'      => 1,
        'theme_modifyby'    => $this->session->get('zd_uid'),
        'theme_modifyon'    => date('Y-m-d H:i:s'),
    ];

    //  Insert or Update
    if (empty($theme_id)) {
        $data['theme_createdon'] = date('Y-m-d H:i:s');
        $data['theme_createdby'] = $this->session->get('zd_uid');
        $this->theme_Model->insert_data($data);

        // Get last inserted ID
        $themeId = $this->theme_Model->insertID();

        // Deactivate others
        $this->theme_Model->deactivateAllThemesExcept($themeId);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Theme created successfully.'
        ]);
    } else {
        $existing = $this->theme_Model->getThemeByid($theme_id);
        if (!$existing) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Theme not found.']);
        }

        $this->theme_Model->modifyThemes($theme_id, $data);
        $this->theme_Model->deactivateAllThemesExcept($theme_id);

        return $this->response->setJSON([
            'status' => 1,
            'msg'   => 'Theme updated successfully.',
            'redirect' => base_url('admin/themes')
        ]);
    }
}


/***************************************************************************************************/

	public function ajaxList()
	{
		$model = new \App\Models\Admin\Theme_Model();
		$data = $model->getDatatables();
		$total = $model->countAll();
		$filtered = $model->countFiltered();

		$start = $this->request->getPost('start'); // DataTables offset

		foreach ($data as $key => &$row) {
			// Add serial number (DT_RowIndex)
			$row['DT_RowIndex'] = $start + $key + 1;

			// Default fallback
			$row['theme_Name'] = $row['theme_Name'] ?? 'N/A';
			$row['theme_Description'] = $row['theme_Description'] ?? 'N/A';

			// Status toggle switch (checkbox using theme_Status)
		   $row['status_switch'] = '
		<div class="form-check form-switch">
			<input class="form-check-input checkactive"
				   type="checkbox"
				   id="statusSwitch-' . $row['theme_Id'] . '"
				   value="' . $row['theme_Id'] . '" ' . ($row['theme_Status'] == 1 ? 'checked' : '') . '>
			<label class="form-check-label pl-0 label-check"
				   for="statusSwitch-' . $row['theme_Id'] . '"></label>
		</div>';

			// Action buttons
			$row['actions'] = '<a href="' . base_url('admin/themes/add/' . $row['theme_Id']) . '">
					<i class="bi bi-pencil-square"></i>
				</a>&nbsp;
				<i class="bi bi-trash text-danger icon-clickable"
				   onclick="confirmDelete(' . $row['theme_Id'] . ')"></i>';
		}

		return $this->response->setJSON([
			'draw' => intval($this->request->getPost('draw')),
			'recordsTotal' => $total,
			'recordsFiltered' => $filtered,
			'data' => $data
		]);
	}


/***************************************************************************************************/

}

